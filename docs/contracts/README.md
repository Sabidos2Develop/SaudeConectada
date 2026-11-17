# Contratos internos

Os contratos compartilhados entre os componentes do Saúde Conectada devem ser definidos, documentados e versionados nesta pasta.

## Telemetria da SmartBand

- [Contrato interno de telemetria v1.0](telemetry-v1.md)

### Premissas confirmadas

- Um único simulador representa a SmartBand e usa o identificador constante `smartband-01` no ambiente de demonstração.
- A SmartBand reúne sensores; cada requisição representa uma medição ou evento.
- A pressão arterial é uma medição composta em um único payload (`systolic` e `diastolic`).
- O envio ocorre diretamente por HTTP + JSON à API REST PHP 8, sem broker/intermediário.
- A API recebe e valida as mensagens.
- SmartCity Lab é somente o contexto acadêmico, não uma plataforma externa.

O documento v1.0 especifica envelope, tipos JSON, unidades, exemplos, validações e pendências operacionais. Sua publicação formaliza a proposta técnica acordada; alterações incompatíveis exigem versionamento e revisão coordenada do simulador e da API.
