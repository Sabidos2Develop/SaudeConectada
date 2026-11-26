# Backend — API REST

Base executável da API REST do Saúde Conectada, implementada em PHP puro e sem framework ou micro-framework.

## Requisitos

- PHP 8.0 ou superior, com extensão JSON habilitada.
- Composer 2.x.
- `curl` para executar a verificação HTTP manual (opcional).

## Instalação

A partir deste diretório (`backend/`), gere o autoload do Composer:

```bash
composer install
```

O projeto não adiciona bibliotecas externas nesta etapa. O Composer é utilizado para declarar a plataforma PHP e gerar o autoload PSR-4.

## Execução local

Ainda dentro de `backend/`:

```bash
composer run serve
```

O servidor de desenvolvimento ficará disponível em `http://127.0.0.1:8080`.

Verifique a inicialização em outro terminal:

```bash
curl -i http://127.0.0.1:8080/health
```

A rota `GET /health` é apenas uma verificação técnica de disponibilidade. Ela não recebe telemetria nem representa um contrato funcional de negócio.

## Teste básico

Com o autoload gerado, execute:

```bash
composer test
```

O teste verifica a resposta do health check, o cabeçalho JSON e o comportamento de rota não registrada. Para validar a comunicação HTTP real, execute também o `curl` descrito acima.

## Organização

```text
backend/
├── composer.json
├── public/
│   └── index.php              # Entrada HTTP
├── src/
│   ├── Application.php        # Composição da aplicação
│   ├── Controllers/
│   │   └── HealthController.php
│   └── Http/
│       ├── Request.php        # Leitura/representação da requisição
│       ├── Response.php       # Construção e envio de respostas
│       └── Router.php         # Resolução de método e caminho
└── README.md
```

## Configuração e segurança

- Segredos e configurações locais não devem ser versionados. O `.gitignore` da raiz já exclui arquivos `.env`.
- Não há credenciais, conexão com banco ou serviços externos configurados nesta etapa.
- Erros inesperados retornam uma resposta genérica HTTP 500; detalhes internos não são enviados ao cliente.
- Utilize somente dados fictícios ou anonimizados nos próximos incrementos.

## Limites desta entrega — Issue #4

Esta etapa prepara a estrutura executável e a separação básica entre entrada HTTP, roteamento, controller e resposta. Permanecem fora do escopo:

- endpoint `POST /api/v1/telemetry` (Issue #5);
- validação do contrato SC-TELEMETRY v1.0 no servidor (Issue #6);
- persistência MariaDB (Incremento 2);
- autenticação/autorização do dispositivo;
- integração com serviço de IA.

Essas funcionalidades devem ser implementadas somente nas Issues e incrementos correspondentes, respeitando as decisões aprovadas.
