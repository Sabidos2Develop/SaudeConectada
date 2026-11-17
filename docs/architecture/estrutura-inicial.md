# Estrutura inicial do repositório

> Status: proposta inicial de organização. A estrutura não aprova frameworks, bibliotecas ou detalhes de contrato que ainda estejam pendentes.

## Contexto e fluxo confirmado

SmartCity Lab é o contexto acadêmico em que o Saúde Conectada está inserido, não um sistema externo ou plataforma de integração.

O Incremento 1 prevê um único simulador que representa uma SmartBand com vários sensores. O simulador envia telemetria diretamente à API REST PHP 8, sem intermediador. O backend recebe e valida os dados.

A arquitetura do Saúde Conectada é responsável por definir o contrato interno padronizado utilizado pelo simulador e pelo backend.

`Simulador SmartBand → comunicação direta → API REST PHP 8`

A persistência em MariaDB está prevista para o Incremento 2.

## Princípios

1. Manter o fluxo interno entre simulador, comunicação e API REST PHP 8.
2. Não introduzir plataforma ou contrato externo SmartCity Lab.
3. Compartilhar um contrato interno versionado entre simulador e backend.
4. Separar documentação, backend, simulador e testes.
5. Usar dados fictícios ou anonimizados em exemplos e testes.
6. Não versionar credenciais, tokens, arquivos locais ou dados pessoais reais.

## Estrutura planejada

```text
SaudeConectada/
├── backend/
│   ├── public/             # Ponto de entrada HTTP da API
│   ├── src/                # Código da aplicação (organização interna pendente)
│   ├── config/             # Configurações não secretas e exemplos
│   └── README.md
├── iot/
│   └── simulator/          # Simulador único da SmartBand
├── docs/
│   ├── architecture/
│   ├── contracts/
│   ├── decisions/
│   ├── increments/
│   └── api/
├── tests/
│   ├── integration/
│   └── fixtures/
├── .gitignore
├── CONTRIBUTING.md
└── README.md
```

## Decisões ainda não aprovadas

- Framework ou PHP puro.
- Organização interna definitiva do backend (MVC simplificado é proposta).
- Detalhes finais do protocolo HTTP e eventual necessidade futura de MQTT.
- Estrutura definitiva do envelope e cardinalidade das medições por mensagem.
- Autenticação e credenciais do dispositivo.
- Formato definitivo de erros e respostas HTTP.

## Regras de contribuição

- Desenvolver em branches de trabalho e abrir Pull Request para integração na `main`.
- Não fazer commits diretamente na `main` durante o desenvolvimento colaborativo.
- Toda mudança funcional deve apontar para uma Issue.
- PR deve descrever alteração, requisito relacionado, testes executados, limitações e decisões pendentes.
- Não marcar testes como aprovados sem evidência de execução.
