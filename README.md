# Saúde Conectada

Projeto acadêmico do SmartCity Lab para acompanhamento preventivo comunitário, utilizando dispositivos IoT ou simuladores, API, armazenamento de dados e apoio à organização das informações para profissionais de saúde.

> O sistema apoia o acompanhamento e a análise por profissionais autorizados. Não realiza diagnóstico, prescrição ou decisões clínicas autônomas.

## Arquitetura de referência

`Dispositivo/Simulador → Comunicação (HTTP e/ou MQTT) → API REST PHP 8 → MariaDB → Serviço de IA → Aplicação Web/Móvel`

A escolha final do protocolo e o contrato de telemetria devem respeitar a especificação oficial do SmartCity Lab. Enquanto não houver confirmação, qualquer contrato alternativo deve ser identificado como provisório.

## Tecnologias confirmadas

- Backend: PHP 8
- API: REST
- Banco de dados: MariaDB
- Comunicação IoT: HTTP e/ou MQTT (protocolo final pendente)
- Frontend: HTML, CSS e JavaScript
- Dispositivos: IoT real ou simulador

Frameworks, bibliotecas e detalhes adicionais permanecem sujeitos às decisões registradas.

## Documentação

- [Índice da documentação](docs/README.md)
- [Estrutura inicial do repositório](docs/architecture/estrutura-inicial.md)
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
