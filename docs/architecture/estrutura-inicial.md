# Estrutura inicial do repositório

> Status: proposta inicial de organização. A estrutura não aprova frameworks, bibliotecas ou detalhes ainda pendentes.

## Contexto e fluxo acordado

SmartCity Lab é o contexto acadêmico em que o Saúde Conectada está inserido, não um sistema externo ou plataforma de integração.

O Incremento 1 utiliza um único simulador que representa uma SmartBand com vários sensores. O simulador envia telemetria diretamente à API REST PHP 8 por HTTP + JSON, sem intermediador. O backend recebe e valida os dados.

`Simulador SmartBand (smartband-01) → HTTP POST + JSON → API REST PHP 8`

Cada requisição transporta uma medição ou evento. A pressão arterial é uma medição composta com dois valores no mesmo objeto. O contrato está em `docs/contracts/telemetry-v1.md`.

A persistência definitiva em MariaDB está prevista para o Incremento 2.

## Princípios

1. Manter o fluxo interno entre simulador, comunicação e API REST PHP 8.
2. Não introduzir plataforma ou contrato externo SmartCity Lab.
3. Compartilhar contrato interno versionado entre simulador e backend.
4. Separar documentação, backend, simulador e testes.
5. Usar dados fictícios ou anonimizados.
6. Não versionar credenciais, tokens ou dados pessoais reais.
7. Não criar limites clínicos sem fonte e aprovação.

## Estrutura

```text
SaudeConectada/
├── backend/
│   ├── public/
│   ├── src/
│   ├── config/
│   └── README.md
├── iot/
│   └── simulator/
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

## Pendências técnicas

- Framework ou PHP puro.
- Organização interna definitiva do backend.
- Autenticação e credenciais do dispositivo.
- HTTPS para ambientes publicados.
- Timeout, retentativas, idempotência e limites operacionais.
- CORS e contrato definitivo de erros/respostas HTTP.

## Regras de contribuição

- Desenvolver em branches e abrir Pull Request para integração na `main`.
- Não fazer commits diretamente na `main`.
- Toda mudança funcional deve apontar para uma Issue.
- PR deve descrever alteração, requisito, testes executados, limitações e pendências.
- Não declarar testes aprovados sem evidência.
