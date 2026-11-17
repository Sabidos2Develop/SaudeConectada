# Registro de decisões técnicas

Decisões que alterem arquitetura, tecnologia, segurança, contrato de dados ou regras de negócio devem ser registradas antes da implementação definitiva.

## Identificação das decisões

Use IDs sequenciais, por exemplo: DEC-001.

Cada registro deve conter:

- **ID e data**
- **Status:** Pendente, Proposta, Aprovada ou Rejeitada
- **Contexto/problema**
- **Opções consideradas**
- **Decisão adotada**
- **Justificativa**
- **Componentes afetados**
- **Riscos e impactos**
- **Responsável pela aprovação humana**
- **Issues/PRs relacionados**

## Decisões abertas relevantes para o Incremento 1

- DEC-001 — Definir o contrato interno de telemetria compartilhado pelo simulador da SmartBand e pela API.
- DEC-002 — Definir protocolo de comunicação direta e segurança entre simulador e API REST.
- DEC-010 — Credenciais/autenticação do dispositivo.
- DEC-020 — Contrato de status HTTP e erros da API.

## Premissas arquiteturais já confirmadas

- SmartCity Lab é o contexto acadêmico, não um sistema externo.
- Existe um simulador único representando a SmartBand e reunindo os diferentes sensores.
- O envio planejado é direto do simulador à API, sem intermediador.
- O backend é responsável por receber e validar os dados.
- A equipe de arquitetura do Saúde Conectada define o contrato interno padronizado.

As premissas confirmadas não substituem decisões ainda pendentes, como protocolo detalhado, autenticação e formato exato do payload.
