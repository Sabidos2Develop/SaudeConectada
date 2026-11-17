# Estrutura inicial do repositório

> Status: proposta inicial de organização. A estrutura não aprova frameworks, bibliotecas ou contratos que estejam pendentes na especificação-base.

## Princípios

1. Manter a arquitetura de referência: dispositivo/simulador → comunicação HTTP e/ou MQTT → API REST PHP 8.
2. Separar documentação, backend, simuladores e testes.
3. Evitar dependências e decisões irreversíveis antes das aprovações necessárias.
4. Usar dados fictícios ou anonimizados em exemplos e testes.
5. Não versionar credenciais, tokens, arquivos locais ou dados pessoais reais.

## Estrutura planejada

```text
SaudeConectada/
├── backend/
│   ├── public/             # Ponto de entrada HTTP da API
│   ├── src/                # Código da aplicação (organização interna pendente)
│   ├── config/             # Configurações não secretas e exemplos
│   └── README.md
├── iot/
│   └── simulator/          # Simulador e cenários de telemetria
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
- Protocolo final HTTP, MQTT ou ambos.
- Contrato oficial de telemetria do SmartCity Lab.
- Autenticação e credenciais dos dispositivos.
- Formato definitivo de erros e respostas HTTP.

## Regras de contribuição

- Desenvolver em branches de trabalho e abrir Pull Request para integração na `main`.
- Não fazer commits diretamente na `main` durante o desenvolvimento colaborativo.
- Toda mudança funcional deve apontar para uma Issue.
- PR deve descrever alteração, requisito relacionado, testes executados, limitações e decisões pendentes.
- Não marcar testes como aprovados sem evidência de execução.
