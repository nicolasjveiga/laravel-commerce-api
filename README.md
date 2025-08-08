# 🛍 Laravel Commerce API + Docker + Grafana

## 🚀 Acesso Rápido

| Serviço         | URL                          | Usuário / Senha     |
|----------------|------------------------------|---------------------|
| 🌐 phpMyAdmin     | `http://localhost:8075`       | `root` / `root`     |
| 🧪 API Backend    | `http://localhost:8005/api`   | —                   |
| 📊 Grafana        | `http://localhost:3000`       | `admin` / `admin`   |

## 🐳 Como Rodar o Projeto (Docker)

```bash
docker compose up -d
```

---

## ⚙️ Configuração Inicial

1. **Crie o arquivo `.env`:**
   ```bash
   cp .env.example .env
   ```

2. **Acesse o terminal dentro do container:**
   ```bash
   docker compose exec --user 1000:1000 app sh
   ```

3. **Instale as dependências do Laravel:**
   ```bash
   composer update
   ```

4. **Gere a chave da aplicação:**
   ```bash
   php artisan key:generate
   ```

5. **Execute as migrações:**
   ```bash
   php artisan migrate
   ```
6. **Rode os seeders**
   ```bash
   php artisan db:seed
   ```

---

## 📊  Configurando o Grafana

### 1. Adicionar Data Source do MySQL
- Acesse o Grafana em: `http://localhost:3000`
- Faça login com `admin / admin` (caso ainda não tenha alterado)
- Vá em: **Configuration → Data Sources → Add data source → MySQL**
- Preencha os campos:
  - **Host:** `db:3306`
  - **Database:** `laravel`
  - **Username:** `root`
  - **Password:** `root`
- Marque como **Default**
- Clique em **Save & Test** — deve aparecer: *Database Connection OK*

### 📥 2. Importar Dashboards
- Navegue até: **Create → Import**
- Selecione o arquivo: `grafana/graph.json`
- Não precisa selecionar UID — ele usará o Data Source Default automaticamente
- Clique em **Import** e os dashboards aparecerão configurados corretamente

> 💡 **Dica caso algo dê errado:**  
> Se o dashboard reclamar que não encontrou a fonte ou UID inválido, abra o JSON e remova qualquer `"uid": "xxxxx"` dentro da seção `datasource`. Reimporte depois. Pronto!

---
