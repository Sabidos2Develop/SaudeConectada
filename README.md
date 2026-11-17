# Saúde Conectada

Projeto acadêmico desenvolvido no contexto do SmartCity Lab para acompanhamento preventivo comunitário, utilizando um dispositivo vestível simulado, API, armazenamento de dados e apoio à organização das informações para profissionais de saúde.

> SmartCity Lab identifica o contexto acadêmico do projeto. Não representa uma plataforma, fornecedor ou sistema externo a integrar. Os componentes e contratos de telemetria serão desenvolvidos internamente pelo Saúde Conectada.

> O sistema apoia o acompanhamento e a análise por profissionais autorizados. Não realiza diagnóstico, prescrição ou decisões clínicas autônomas.

## Arquitetura inicial

`Simulador de SmartBand → comunicação direta → API REST PHP 8 → MariaDB → Serviço de IA → Aplicação Web/Móvel`

No Incremento 1, o simulador representa uma única SmartBand que reúne medições de diferentes sensores e envia os dados diretamente à API. Não há intermediador planejado. A API é responsável por receber e validar as mensagens.

A arquitetura do Saúde Conectada define o contrato interno padronizado compartilhado entre o simulador e o backend. A estrutura detalhada do payload e o protocolo de transporte serão registrados nas decisões e contratos do repositório.

## Tecnologias confirmadas

- Backend: PHP 8
- API: REST
- Banco de dados: MariaDB
- Dispositivo: simulador único representando uma SmartBand
- Comunicação: envio direto do simulador à API; detalhes do protocolo e segurança serão registrados em decisão técnica
- Frontend: HTML, CSS e JavaScript

Frameworks, bibliotecas e detalhes adicionais permanecem sujeitos às decisões registradas.

## Documentação

- [Índice da documentação](docs/README.md)
- [Estrutura inicial do repositório](docs/architecture/estrutura-inicial.md)
- [Contratos internos](docs/contracts/README.md)
- [Backlog do Incremento 1](docs/increments/incremento-1-backlog.md)
- [Registro de decisões técnicas](docs/decisions/README.md)
- [Como contribuir](CONTRIBUTING.md)

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
