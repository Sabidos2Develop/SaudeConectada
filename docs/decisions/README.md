# Registro de decisões técnicas

Decisões que alterem arquitetura, tecnologia, segurança, contrato de dados ou regras de negócio devem ser registradas antes da implementação definitiva.

## Identificação das decisões

Use IDs sequenciais, por exemplo: DEC-001. Cada registro deve conter data, status, contexto, decisão, justificativa, componentes afetados, riscos, aprovação humana e Issues/PRs relacionados.

## Decisões do Incremento 1

- [DEC-001 — Contrato interno de telemetria v1.0](DEC-001-telemetria.md) — aprovada pelo responsável do projeto; evolução do contrato deve ser coordenada.
- [DEC-002 — HTTP + JSON direto](DEC-002-http-json.md) — protocolo e formato de transporte aprovados; segurança operacional detalhada permanece pendente.
- DEC-010 — Credenciais/autenticação do dispositivo: pendente.
- DEC-020 — Contrato definitivo de status HTTP e erros da API: pendente.

## Premissas arquiteturais confirmadas

- SmartCity Lab é o contexto acadêmico, não um sistema externo.
- Existe um simulador único representando a SmartBand e reunindo diferentes sensores.
- O envio ocorre diretamente à API, sem intermediador.
- O backend recebe e valida os dados.
- A equipe de arquitetura do Saúde Conectada define o contrato interno padronizado.
