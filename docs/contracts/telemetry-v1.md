# Contrato interno de telemetria da SmartBand

- **Identificador:** SC-TELEMETRY
- **Versão:** 1.0
- **Status:** proposta técnica formalizada para revisão/aprovação da equipe
- **Escopo:** Incremento 1 — comunicação e recebimento; persistência definitiva permanece no Incremento 2.

## 1. Premissas confirmadas

- Um único simulador representa uma SmartBand que reúne os sensores.
- O identificador do dispositivo é único e constante nas mensagens: `smartband-01` no ambiente de demonstração.
- Cada requisição representa **uma medição ou um evento**. A pressão arterial é uma única medição composta, não duas requisições.
- O simulador envia diretamente à API REST PHP 8 por HTTP, sem broker/intermediário.
- A API recebe e valida os dados.
- O contrato é interno ao Saúde Conectada. SmartCity Lab é somente o contexto acadêmico.

## 2. Transporte e endpoint

| Item | Definição |
|---|---|
| Método | `POST` |
| Endpoint proposto | `/api/v1/telemetry` |
| Content-Type | `application/json` |
| Accept | `application/json` |
| Transporte | HTTP no desenvolvimento local; HTTPS obrigatório quando exposto fora de ambiente local controlado |
| Intermediário | Nenhum |

O endpoint é uma proposta de rota para o Incremento 1. A implementação deve confirmá-la e documentar a URL base efetiva.

## 3. Envelope da mensagem

Todos os campos abaixo são obrigatórios, exceto `unit`, que é obrigatório apenas para métricas físicas.

| Campo | Tipo JSON | Obrigatório | Regra |
|---|---|---:|---|
| `schema_version` | string | Sim | Versão do contrato, atualmente `"1.0"` |
| `device_id` | string | Sim | Identificador estável da SmartBand; não muda por sensor |
| `patient_id` | string | Sim | Identificador fictício/anonimizado associado à medição |
| `metric` | string | Sim | Um dos códigos definidos na seção 4 |
| `value` | number, object ou boolean | Sim | Tipo depende de `metric`; não converter tudo para string |
| `unit` | string | Condicional | Unidade exigida para métricas quantitativas |
| `timestamp` | string | Sim | Instante da medição em ISO 8601 com fuso explícito; preferir UTC (`Z`) |

### Regras gerais

- Rejeitar propriedades obrigatórias ausentes, tipos incompatíveis e valores não parseáveis.
- Rejeitar `device_id` vazio e `patient_id` vazio.
- O servidor deve validar o identificador do dispositivo contra os dispositivos autorizados/configurados; o valor enviado pelo cliente não é prova de autenticação.
- Validar que `timestamp` seja uma data/hora ISO 8601 válida com timezone. Não aceitar data local ambígua.
- Não confiar no relógio do dispositivo como horário de recebimento: a API deve registrar separadamente o instante de recebimento.
- Não aplicar limiares clínicos, diagnóstico, prescrição ou regras de alerta neste contrato.
- Campos desconhecidos: a implementação v1 deve rejeitá-los ou ignorá-los de forma consistente; recomendação para a primeira versão: rejeitar para detectar divergências cedo.

## 4. Métricas e tipos

| `metric` | `value` | `unit` | Descrição |
|---|---|---|---|
| `spo2` | number | `%` | Saturação periférica de oxigênio |
| `heart_rate` | number | `bpm` | Frequência cardíaca |
| `temperature` | number | `°C` | Temperatura |
| `blood_pressure` | object | `mmHg` | Pressão sistólica e diastólica em um único evento |
| `fall_sensor` | boolean | Não enviar | Estado/evento do sensor de queda |
| `panic_button` | boolean | Não enviar | Estado do botão de auxílio; `true` representa acionamento |

Para `blood_pressure`, `value` deve conter exatamente duas propriedades numéricas:
- `systolic`: pressão sistólica.
- `diastolic`: pressão diastólica.

O contrato valida estrutura e tipo, não define faixas clínicas ou interpretações médicas. Restrições numéricas de domínio além de serem números finitos precisam de validação e justificativa documentadas antes de serem impostas.

## 5. Exemplos válidos

### SpO2

```json
{
  "schema_version": "1.0",
  "device_id": "smartband-01",
  "patient_id": "pat-9921",
  "metric": "spo2",
  "value": 98,
  "unit": "%",
  "timestamp": "2026-11-17T17:48:29.753Z"
}
```

### Frequência cardíaca

```json
{
  "schema_version": "1.0",
  "device_id": "smartband-01",
  "patient_id": "pat-9921",
  "metric": "heart_rate",
  "value": 85,
  "unit": "bpm",
  "timestamp": "2026-11-17T17:48:29.753Z"
}
```

### Temperatura

```json
{
  "schema_version": "1.0",
  "device_id": "smartband-01",
  "patient_id": "pat-9921",
  "metric": "temperature",
  "value": 36.5,
  "unit": "°C",
  "timestamp": "2026-11-17T17:48:29.753Z"
}
```

### Pressão arterial — uma medição composta

```json
{
  "schema_version": "1.0",
  "device_id": "smartband-01",
  "patient_id": "pat-9921",
  "metric": "blood_pressure",
  "value": {
    "systolic": 120,
    "diastolic": 80
  },
  "unit": "mmHg",
  "timestamp": "2026-11-17T17:48:29.753Z"
}
```

### Queda e botão de auxílio

```json
{
  "schema_version": "1.0",
  "device_id": "smartband-01",
  "patient_id": "pat-9921",
  "metric": "fall_sensor",
  "value": true,
  "timestamp": "2026-11-17T17:48:29.753Z"
}
```

```json
{
  "schema_version": "1.0",
  "device_id": "smartband-01",
  "patient_id": "pat-9921",
  "metric": "panic_button",
  "value": true,
  "timestamp": "2026-11-17T17:48:29.753Z"
}
```

## 6. Exemplos inválidos

- `value: "98"` para `spo2`: tipo string, deveria ser number.
- `value: "120/80"` para `blood_pressure`: string, deveria ser objeto com `systolic` e `diastolic`.
- `value: 1` para `fall_sensor` ou `panic_button`: número, deveria ser boolean.
- `unit` ausente para `spo2`, `heart_rate`, `temperature` ou `blood_pressure`.
- `timestamp` sem timezone ou em formato inválido.
- `metric` não reconhecida ou `schema_version` incompatível.
- `device_id` ou `patient_id` vazio.

## 7. Resposta HTTP

Proposta inicial para o endpoint de recebimento (sem afirmar persistência no Incremento 1):

- `202 Accepted`: mensagem recebida e aceita pela API para processamento/fluxo do incremento.
- `400 Bad Request`: JSON malformado ou envelope estruturalmente inválido.
- `401 Unauthorized` / `403 Forbidden`: dispositivo não autenticado ou não autorizado, conforme estratégia de autenticação definida.
- `415 Unsupported Media Type`: Content-Type não suportado.
- `422 Unprocessable Content`: JSON válido, mas campos/tipos/valores incompatíveis com o contrato.
- `500 Internal Server Error`: falha inesperada, sem expor stack trace ou segredos.

O formato padronizado do corpo de erro e os detalhes de autenticação ainda precisam ser registrados na decisão própria da API. O Incremento 1 não deve responder que os dados foram persistidos no MariaDB, pois a persistência definitiva pertence ao Incremento 2.

## 8. Segurança, operação e pendências

**Diretrizes confirmadas:** comunicação direta HTTP/JSON, sem broker, validação no backend.

**Ainda pendente de decisão/implementação:** autenticação do dispositivo, gestão de credenciais, HTTPS no ambiente publicado, timeout, retentativas, idempotência, limites de tamanho/frequência, política para timestamps futuros/antigos, formato definitivo de erros e armazenamento do instante de recebimento.

Não embutir segredo no HTML/JavaScript: qualquer credencial colocada no navegador pode ser inspecionada. O identificador `device_id` identifica a origem lógica, mas não substitui autenticação.

## 9. Compatibilidade e evolução

- A versão é explícita em `schema_version`.
- Mudanças incompatíveis exigem nova versão principal do contrato e evolução coordenada do simulador e da API.
- Mudanças compatíveis devem ser documentadas e avaliadas quanto ao comportamento de clientes existentes.
- Exemplos e testes de contrato devem ser compartilhados entre IoT e Backend.
- Esta especificação não declara que a API ou a persistência já estejam implementadas.

## 10. Relação com as decisões

- DEC-001: envelope, cardinalidade e tipos do contrato de telemetria.
- DEC-002: HTTP + JSON direto, sem intermediador; detalhes operacionais e de segurança continuam pendentes.
