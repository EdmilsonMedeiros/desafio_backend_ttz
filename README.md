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

[Vídeo de Apresentação](https://drive.google.com/file/d/1IuTl6k5EZt-HpNUb7zRty3aH0qsWPjJ2/view?usp=sharing)

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

### 🎯 **Funcionalidades Extras Desenvolvidas**

#### Sistema de Jobs
- ✅ **Processamento em background** via Laravel Queue
- ✅ **Sistema de retry** com backoff exponencial (re-tentativas dos jobs com intervalos)
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
- ✅ **Paginação eficiente** em todos os endpoints
- ✅ **Filtros avançados** por data, categoria, tipo

## 🛠 Tecnologias

- **Framework:** Laravel ^12.0
- **Banco de Dados:** MySQL 8.0+
- **Autenticação:** Laravel Sanctum
- **Queue:** Laravel Queue (Database/Redis)
- **PHP:** 8.2+

## 🚀 Instalação

### Pré-requisitos
- PHP 8.2 ou superior
- Composer
- MySQL 8.0 ou superior

### 1. Clone o Repositório
```bash
git clone https://github.com/EdmilsonMedeiros/desafio_backend_ttz.git
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

### Para servir a aplicação
```bash
php artisan serve
```

## 📄 Documentação da API
Ao acessar a rota raíz do projeto, você encontrará um botão linkado com a documentação da API com todas as informações necessárias para utilizar. Também, neste link [https://github.com/EdmilsonMedeiros/desafio_backend_ttz/blob/master/Insomnia_2025-08-09.yaml] está disponível um arquivo insomnia para importação de todas as rotas já configuradas e com paramêtros para facilitar os testes.

### 🔑 CREDÊNCIAIS
```bash
admin@gmail.com
```
```bash
admin
```