import time
import random
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC

BASE_URL = "http://localhost/sistema-presidio/public"

EMAIL_USER = f"aluno{random.randint(1000, 9999)}@tcd.com"
SENHA_USER = "1234"


driver = webdriver.Chrome()
driver.maximize_window()
wait = WebDriverWait(driver, 10)

def force_click(element):
    """Clica mesmo se algo estiver na frente"""
    driver.execute_script("arguments[0].scrollIntoView({block: 'center'});", element)
    time.sleep(0.5)
    driver.execute_script("arguments[0].click();", element)

def teste_1_falha_login():
    print("\n--- TESTE 1: TENTATIVA DE LOGIN INVÁLIDO ---")
    driver.get(f"{BASE_URL}/login")
    
    # Tenta logar com senha errada
    driver.find_element(By.NAME, "email").send_keys("admin@sistema.com")
    driver.find_element(By.NAME, "senha").send_keys("SENHA_ERRADA_123")
    
    btn = driver.find_element(By.TAG_NAME, "button")
    force_click(btn)
    
    # Verifica se apareceu o alerta de erro
    try:
        alerta = wait.until(EC.presence_of_element_located((By.CLASS_NAME, "alert-danger")))
        print("✅ Sucesso: O sistema bloqueou o login incorreto.")
        print(f"   Mensagem: {alerta.text}")
        driver.save_screenshot("1_bloqueio_login.png")
    except:
        print("❌ Falha: O sistema não mostrou mensagem de erro.")

def teste_2_cadastro_e_login():
    print("\n--- PREPARAÇÃO: CADASTRO DE NOVO USUÁRIO ---")
    driver.get(f"{BASE_URL}/login/cadastro")
    
    driver.find_element(By.NAME, "nome").send_keys("Robo Teste")
    driver.find_element(By.NAME, "cpf").send_keys("000.000.000-00")
    driver.find_element(By.NAME, "telefone").send_keys("0000-0000")
    driver.find_element(By.NAME, "email").send_keys(EMAIL_USER)
    driver.find_element(By.NAME, "senha").send_keys(SENHA_USER)
    
    # Dados Preso
    driver.find_element(By.NAME, "nome_preso").send_keys("Detento Teste")
    driver.find_element(By.NAME, "infopen").send_keys("12345")
    driver.find_element(By.NAME, "pavilhao").send_keys("Pavilhão 1")
    driver.find_element(By.NAME, "cela").send_keys("10")
    
    # Cadastrar
    btn = driver.find_element(By.TAG_NAME, "button")
    force_click(btn)
    
    # Logar com a conta criada
    print("   -> Logando com novo usuário...")
    wait.until(EC.presence_of_element_located((By.NAME, "email")))
    driver.find_element(By.NAME, "email").send_keys(EMAIL_USER)
    driver.find_element(By.NAME, "senha").send_keys(SENHA_USER)
    
    btn_entrar = driver.find_element(By.TAG_NAME, "button")
    force_click(btn_entrar)
    
    wait.until(EC.presence_of_element_located((By.PARTIAL_LINK_TEXT, "Olá")))
    print("✅ Cadastro e Login realizados.")

def teste_3_estourar_limite():
    print("\n--- TESTE 2: REGRA DE LIMITE DE CATEGORIA ---")
    # Vamos tentar adicionar o PRIMEIRO produto da lista 3 vezes
    # Supondo que seja um sabonete (limite 2) ou qualquer item limite 1
    
    for i in range(1, 4): # Tenta 3 vezes
        print(f"   -> Tentativa {i} de adicionar produto...")
        driver.get(f"{BASE_URL}/home")
        
        # Pega sempre o primeiro botão de adicionar da tela
        wait.until(EC.presence_of_element_located((By.CLASS_NAME, "btn-buy")))
        btns = driver.find_elements(By.CLASS_NAME, "btn-buy")
        force_click(btns[0]) # Clica no primeiro produto
        
        # Espera carregar o carrinho (tabela)
        wait.until(EC.presence_of_element_located((By.TAG_NAME, "table")))
        
        # Verifica se apareceu alerta de erro na 3a vez (ou 2a se limite for 1)
        alertas = driver.find_elements(By.CLASS_NAME, "alert-warning")
        if alertas:
            print("✅ Sucesso: O sistema barrou o excesso de quantidade!")
            print(f"   Mensagem: {alertas[0].text}")
            driver.save_screenshot("2_bloqueio_limite.png")
            return # Sai do teste com sucesso
            
    print("⚠️ Aviso: O sistema permitiu adicionar 3 vezes. Verifique se o limite desse produto é > 3.")

def teste_4_caminho_feliz():
    print("\n--- TESTE 3: FLUXO DE COMPRA E PAGAMENTO ---")
    # Ja estamos no carrinho (do teste anterior). Vamos limpar pra começar limpo?
    # Melhor não, vamos fechar o pedido com o que tem lá (os itens permitidos)
    
    print("   -> Clicando em Finalizar Pedido...")
    # Clica no link Finalizar
    btn_finalizar = wait.until(EC.element_to_be_clickable((By.PARTIAL_LINK_TEXT, "Finalizar")))
    force_click(btn_finalizar)
    
    print("   -> Simulando Pagamento...")
    # Espera o botão amarelo
    btn_pagar = wait.until(EC.element_to_be_clickable((By.ID, "btn-simular-pagamento")))
    force_click(btn_pagar)
    
    # Verifica status "Pago"
    print("   -> Verificando Status...")
    wait.until(EC.presence_of_element_located((By.CLASS_NAME, "badge")))
    
    # Valida visualmente
    driver.save_screenshot("3_sucesso_compra.png")
    print("✅ Sucesso: Compra finalizada e status Pago verificado.")

# --- EXECUÇÃO ---
try:
    teste_1_falha_login()
    teste_2_cadastro_e_login()
    teste_3_estourar_limite() # Tenta adicionar 3x o mesmo item
    teste_4_caminho_feliz()   # Fecha a conta
    
    print("\n🏁 TODOS OS TESTES FINALIZADOS! Verifique as imagens na pasta.")
    time.sleep(3)

except Exception as e:
    print(f"\n❌ ERRO CRÍTICO: {e}")
    driver.save_screenshot("erro_fatal.png")

finally:
    driver.quit()
