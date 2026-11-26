# Backend — API REST

Base executável da API REST do Saúde Conectada, implementada em PHP puro e sem framework ou micro-framework.

## Requisitos

- PHP 8.0 ou superior, com extensão JSON habilitada.
- Composer 2.x.
- \`curl\` para executar a verificação HTTP manual (opcional).

## Instalação

A partir deste diretório (\`backend/\`), gere o autoload do Composer:

\`\`\`bash
composer install
\`\`\`

O projeto não adiciona bibliotecas externas nesta etapa. O Composer é utilizado para declarar a plataforma PHP e gerar o autoload PSR-4.

## Execução local

Ainda dentro de \`backend/\`:

\`\`\`bash
composer run serve
\`\`\`

O servidor de desenvolvimento ficará disponível em \`http://127.0.0.1:8080\`.

Verifique a inicialização em outro terminal:

\`\`\`bash
curl -i http://127.0.0.1:8080/health
\`\`\`

A rota \`GET /health\` é apenas uma verificação técnica de disponibilidade. Ela não recebe telemetria nem representa um contrato funcional de negócio.

## Testes

Com o autoload gerado, execute na pasta \`backend/\`:

\`\`\`bash
composer test
\`\`\`

O comando executa os testes básicos do esqueleto HTTP e os testes automatizados da validação de telemetria. A suíte de validação cobre as seis métricas, tipos JSON, campos obrigatórios, versão, unidade, timestamp com timezone e rejeição de campos não previstos no contrato v1.0.

## Organização

\`\`\`text
backend/
├── composer.json
├── public/
│   └── index.php              # Entrada HTTP
├── src/
│   ├── Application.php        # Composição da aplicação
│   ├── Controllers/
│   │   └── HealthController.php
│   ├── Http/
│   │   ├── Request.php        # Leitura/representação da requisição
│   │   ├── Response.php       # Construção e envio de respostas
│   │   └── Router.php         # Resolução de método e caminho
│   └── Validation/
│       └── Telemetry/
│           ├── TelemetryMessageValidator.php
│           └── TelemetryValidationResult.php
└── README.md
\`\`\`

## Validação de telemetria

\`TelemetryMessageValidator\` recebe um objeto produzido por \`json_decode($json)\` (sem o modo associativo) e devolve um \`TelemetryValidationResult\`. O resultado informa se a mensagem é válida e, em caso negativo, fornece uma lista de erros com \`field\`, \`code\` e \`message\`, sem copiar valores enviados pelo dispositivo.

A validação aplica exclusivamente as regras estruturais do contrato SC-TELEMETRY v1.0: campos, versão, identificadores não vazios, métrica, tipos JSON, composição da pressão arterial, unidades e timestamp ISO 8601 com timezone explícito. Campos desconhecidos são rejeitados, seguindo a recomendação do contrato.

Não são aplicados limites clínicos, diagnósticos, autenticação do dispositivo, autorização por cadastro, persistência ou regras de alerta. A confirmação de que um \`device_id\` pertence a um dispositivo autorizado depende da estratégia de autenticação/configuração ainda pendente; validar que o identificador foi informado não autentica sua origem.

O serviço não define status HTTP. A camada de endpoint deverá traduzir erros de JSON/transporte e erros de contrato conforme o contrato de API aprovado.

## Configuração e segurança

- Segredos e configurações locais não devem ser versionados. O \`.gitignore\` da raiz já exclui arquivos \`.env\`.
- Não há credenciais, conexão com banco ou serviços externos configurados nesta etapa.
- Erros inesperados retornam uma resposta genérica HTTP 500; detalhes internos não são enviados ao cliente.
- Utilize somente dados fictícios ou anonimizados nos próximos incrementos.

## Limites desta entrega — Issues #4 e #6

Esta etapa mantém a estrutura executável da Issue #4 e adiciona a validação independente do contrato SC-TELEMETRY v1.0, da Issue #6. Permanecem fora do escopo:

- endpoint \`POST /api/v1/telemetry\` (Issue #5);
- persistência MariaDB (Incremento 2);
- autenticação/autorização efetiva do dispositivo;
- integração com serviço de IA.
