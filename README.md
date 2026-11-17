# Saúde Conectada

Projeto acadêmico desenvolvido no contexto do SmartCity Lab para acompanhamento preventivo comunitário, utilizando uma SmartBand simulada, API, armazenamento de dados e apoio à organização das informações para profissionais de saúde.

> SmartCity Lab identifica o contexto acadêmico do projeto. Não representa uma plataforma, fornecedor ou sistema externo a integrar. Os componentes e contratos de telemetria são desenvolvidos internamente pelo Saúde Conectada.

> O sistema apoia o acompanhamento e a análise por profissionais autorizados. Não realiza diagnóstico, prescrição ou decisões clínicas autônomas.

## Arquitetura inicial

`Simulador único da SmartBand → HTTP + JSON → API REST PHP 8 → MariaDB (Incremento 2) → Serviço de IA → Aplicação Web/Móvel`

No Incremento 1, um único simulador reúne as medições dos diferentes sensores e envia cada medição/evento diretamente à API, sem intermediador. A API recebe e valida as mensagens. A pressão arterial é uma medição composta em um único payload.

## Tecnologias confirmadas

- Backend: PHP 8
- API: REST
- Banco de dados: MariaDB
- Dispositivo: simulador único representando uma SmartBand
- Comunicação: HTTP + JSON direto, sem broker
- Frontend do simulador: HTML, CSS e JavaScript

## Documentação

- [Índice da documentação](docs/README.md)
- [Estrutura inicial do repositório](docs/architecture/estrutura-inicial.md)
- [Contrato interno de telemetria v1.0](docs/contracts/telemetry-v1.md)
- [Contratos internos](docs/contracts/README.md)
- [Backlog do Incremento 1](docs/increments/incremento-1-backlog.md)
- [Registro de decisões técnicas](docs/decisions/README.md)
- [Como contribuir](CONTRIBUTING.md)

## Simulador

- [Simulador SmartBand](iot/simulator/simulador-smartband.html)
- [Instruções de execução](iot/simulator/README.md)

## Incrementos

1. Comunicação e coleta de dados
2. Persistência e histórico
3. Acompanhamento e alertas determinísticos
4. Aplicação e indicadores
5. Inteligência Artificial
6. Segurança, auditoria e avaliação

## Regras essenciais

- Usar dados fictícios ou anonimizados.
- Não inventar limites clínicos nem regras de alerta.
- Não versionar credenciais ou segredos.
- Validar telemetria no servidor.
- Manter rastreabilidade entre requisitos, Issues, PRs e testes.
- Submeter decisões relevantes à aprovação humana.

## Estado do desenvolvimento

Consulte as [Issues do repositório](https://github.com/Sabidos2Develop/SaudeConectada/issues) para acompanhar tarefas, dependências e andamento.
