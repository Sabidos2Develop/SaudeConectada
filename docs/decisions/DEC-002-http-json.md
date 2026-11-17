# DEC-002 — Comunicação HTTP + JSON direta

- **Data:** 2026-11-17
- **Status:** Aprovada quanto ao protocolo e formato de transporte; detalhes de segurança/operação pendentes
- **Responsável pela aprovação humana:** responsável do projeto (confirmação nesta conversa)
- **Relacionadas:** Issue #2; contrato SC-TELEMETRY v1.0

## Contexto

O simulador único precisa enviar telemetria diretamente à API REST PHP 8 no escopo acadêmico atual.

## Opções consideradas

- HTTP + JSON diretamente à API;
- MQTT com broker/intermediário.

## Decisão

Adotar HTTP + JSON diretamente à API, por meio de requisições `POST`, sem broker MQTT ou outro intermediário. A rota proposta para o Incremento 1 é `/api/v1/telemetry`.

## Justificativa

A API já é REST e o escopo atual é um único simulador. HTTP reduz componentes operacionais e facilita teste, inspeção e demonstração ponta a ponta.

## Pendências

Autenticação/credenciais, HTTPS no ambiente publicado, timeout, retentativas, idempotência, limites operacionais, CORS e formato definitivo de erros devem ser especificados antes de exposição fora de ambiente local controlado.
