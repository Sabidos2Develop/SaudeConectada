# DEC-001 — Contrato interno de telemetria v1.0

- **Data:** 2026-11-17
- **Status:** Aprovada pelo responsável do projeto
- **Responsável pela aprovação humana:** responsável do projeto (confirmação nesta conversa)
- **Relacionadas:** Issues #1 e #3; PR de formalização do Incremento 1

## Contexto

O simulador único da SmartBand e a API PHP 8 precisam compartilhar um contrato interno estável. SmartCity Lab é apenas o contexto acadêmico, não uma plataforma externa. O dispositivo reúne vários sensores e envia telemetria diretamente à API.

## Decisão

Adotar o contrato [SC-TELEMETRY v1.0](../contracts/telemetry-v1.md), com:

- `schema_version` explícito;
- `device_id` único e constante por dispositivo (exemplo: `smartband-01`);
- uma medição/evento por requisição;
- `patient_id`, `metric`, `value` e `timestamp`;
- `unit` para métricas quantitativas;
- tipos JSON nativos, sem serializar todos os valores como string;
- pressão arterial como uma única medição composta, com `value.systolic` e `value.diastolic`.

## Justificativa

O formato evita ambiguidade de tipos, preserva a relação entre pressão sistólica e diastólica e mantém o envelope simples para validação server-side.

## Impactos e limites

Simulador e API devem implementar a mesma versão. Persistência, regras clínicas, autenticação, idempotência e política detalhada de timestamps não são definidos por esta decisão. Nenhum limite clínico é introduzido.
