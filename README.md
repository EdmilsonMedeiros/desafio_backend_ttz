# Game Log Analytics API

Uma API Laravel robusta para análise de logs de jogos, processamento de eventos e geração de estatísticas em tempo real.

## 📋 Índice

- [Sobre o Projeto](#sobre-o-projeto)
- [Funcionalidades](#funcionalidades)
- [Tecnologias](#tecnologias)
- [Instalação](#instalação)
- [Configuração](#configuração)
- [Uso da API](#uso-da-api)
- [Endpoints](#endpoints)
- [Exemplos de Uso](#exemplos-de-uso)
- [Jobs e Queue](#jobs-e-queue)
- [Estrutura do Banco](#estrutura-do-banco)
- [Contribuição](#contribuição)

## 🎮 Sobre o Projeto

Este projeto foi desenvolvido para processar e analisar logs de jogos, extraindo eventos relevantes e fornecendo APIs para consulta de estatísticas, rankings e métricas de jogadores. O sistema suporta processamento em background de arquivos grandes e possui mecanismos anti-duplicação inteligentes.

## ⚡ Funcionalidades

### 📥 **Requisitos Obrigatórios Implementados**

#### Processamento e Persistência
- ✅ Upload e leitura de arquivos de log
- ✅ Extração automática de campos relevantes
- ✅ Normalização de dados (datas, números, strings)
- ✅ Armazenamento em banco relacional MySQL
- ✅ Sistema anti-duplicação inteligente

#### API Mínima
- ✅ `GET /players` → Lista de jogadores com dados básicos
- ✅ `GET /players/:id/stats` → Estatísticas detalhadas de um jogador
- ✅ `GET /leaderboard` → Ranking de jogadores por pontuação
- ✅ `GET /events` → Últimos eventos (limite configurável)
- ✅ `GET /items/top` → Itens mais coletados

### 🚀 **Desafios Extras Implementados**

#### Dashboard Completo
- ✅ `GET /dashboard` → Métricas completas incluindo:
  - Total de jogadores ativos no intervalo
  - Pontuação total acumulada
  - Itens mais coletados
  - Jogadores com mais mortes
  - Chefes derrotados

#### Atualização Contínua
- ✅ **Sistema híbrido anti-duplicação**:
  - Hash de arquivo (evita reprocessar arquivos idênticos)
  - Hash de evento (detecção rápida de duplicatas)
  - Verificação inteligente por campos únicos
- ✅ **Processamento incremental** sem duplicar dados
- ✅ **Atualização automática** de estatísticas

#### Autenticação
- ✅ Autenticação via Laravel Sanctum
- ✅ Rotas públicas para desenvolvimento/teste

### 🎯 **Funcionalidades Extras Desenvolvidas**

#### Sistema de Jobs
- ✅ **Processamento em background** via Laravel Queue
- ✅ **Sistema de retry** com backoff exponencial
- ✅ **Monitoramento de status** de processamento
- ✅ **Logs detalhados** de processamento

#### APIs Avançadas
- ✅ `GET /events/summary` → Resumo de eventos por categoria
- ✅ `GET /items` → Lista completa de itens com filtros
- ✅ `GET /items/:name/stats` → Estatísticas detalhadas de itens
- ✅ `GET /uploads` → Lista de uploads e status
- ✅ `GET /upload/:id/status` → Status de processamento

#### Otimizações
- ✅ **Cache inteligente** para hashes de eventos
- ✅ **Queries otimizadas** com índices compostos
- ✅ **Paginação eficiente** em todos os endpoints
- ✅ **Filtros avançados** por data, categoria, tipo

## 🛠 Tecnologias

- **Framework:** Laravel 11.x
- **Banco de Dados:** MySQL 8.0+
- **Autenticação:** Laravel Sanctum
- **Queue:** Laravel Queue (Database/Redis)
- **PHP:** 8.2+
- **Cache:** Redis (opcional)

## 🚀 Instalação

### Pré-requisitos
- PHP 8.2 ou superior
- Composer
- MySQL 8.0 ou superior
- Node.js (para assets, se necessário)

### 1. Clone o Repositório
```bash
git clone [SEU_REPOSITÓRIO_AQUI]
cd api_ttz_project
```

### 2. Instale as Dependências
```bash
composer install
```

### 3. Configure o Ambiente
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configure o Banco de Dados
Edite o arquivo `.env` com suas credenciais:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=game_log_analytics
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

### 5. Execute as Migrations
```bash
php artisan migrate
```

### 6. Configure a Queue (Opcional)
Para processamento em background:
```env
QUEUE_CONNECTION=database
```

Execute a migration da queue:
```bash
php artisan queue:table
php artisan migrate
```

### 7. Configure o Storage
```bash
php artisan storage:link
```

## ⚙️ Configuração

### Queue Worker
Para processar arquivos em background, execute:
```bash
php artisan queue:work --tries=3 --timeout=300
```

### Supervisor (Produção)
Para ambiente de produção, configure o Supervisor:
```ini
[program:game-log-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/your/project/artisan queue:work --sleep=3 --tries=3 --max-time=3600
directory=/path/to/your/project
autostart=true
autorestart=true
numprocs=2
user=www-data
```

## 📖 Uso da API

### Autenticação
Para endpoints protegidos, inclua o token no header:
```
Authorization: Bearer {
```
