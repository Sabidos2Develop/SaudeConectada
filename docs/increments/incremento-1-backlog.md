# Incremento 1 — Comunicação e coleta de dados

**Objetivo:** estabelecer e testar o fluxo de telemetria entre o simulador único da SmartBand e a API REST PHP 8.

**Fluxo acordado:** Simulador SmartBand → HTTP + JSON direto (sem intermediador) → API REST PHP 8.

## Escopo e decisões acordadas

- Um único simulador representa uma SmartBand com múltiplos sensores.
- Identificador único e constante no ambiente de demonstração: `smartband-01`.
- O simulador envia cada medição/evento diretamente à API.
- Cada requisição contém uma medição/evento; pressão arterial é uma medição composta no mesmo payload.
- O contrato interno SC-TELEMETRY v1.0 está publicado em `docs/contracts/telemetry-v1.md`.
- O protocolo HTTP + JSON está registrado em `docs/decisions/DEC-002-http-json.md`.
- O backend recebe e valida os dados; persistência definitiva é do Incremento 2.
- SmartCity Lab é somente o contexto acadêmico, sem integração externa.

## Backlog e dependências

| Ordem | Item | Resultado esperado | Dependência |
|---|---|---|---|
| 1 | Contrato interno | Campos, tipos, unidades, cardinalidade, exemplos e validações especificados | DEC-001 / Issue #1 e #3 |
| 2 | Protocolo | HTTP + JSON direto aprovado; segurança operacional detalhada pendente | DEC-002 / Issue #2 |
| 3 | Esqueleto da API | API PHP 8 executável | Issue #4 |
| 4 | Endpoint | Recebimento via POST | Issue #5 |
| 5 | Validação | Validação server-side conforme SC-TELEMETRY v1.0 | Issue #6 |
| 6 | Simulador | SmartBand única, alternância de métricas e envio HTTP real | Issue #7 |
| 7 | Integração e QA | Testes reais simulador → API | Issue #8 |
| 8 | Documentação | Guia reproduzível e limitações | Issue #9 |

## Critérios de aceite do incremento

- [ ] Simulador único gera payloads das seis métricas conforme v1.0.
- [ ] Identificador da SmartBand permanece constante.
- [ ] Pressão arterial é enviada em uma única requisição como objeto com sistólica e diastólica.
- [ ] Simulador envia HTTP POST direto à API, sem broker.
- [ ] API PHP 8 recebe e valida os dados no servidor.
- [ ] Mensagens inválidas são rejeitadas.
- [ ] Falhas de rede, timeout e respostas HTTP são identificáveis.
- [ ] Testes válidos, inválidos e de integração são executados e evidenciados.
- [ ] QA revisa resultados e limitações.

## Fora do escopo

- Persistência definitiva e histórico em MariaDB (Incremento 2).
- Diagnósticos, prescrições, limites clínicos ou regras de alerta sem validação específica.
- IA.
- Credenciais reais embutidas no simulador.

## Pendências

- Autenticação/credenciais do dispositivo.
- HTTPS no ambiente publicado.
- Timeout, retentativas e idempotência.
- CORS e limites operacionais.
- Contrato definitivo de erros/status HTTP.
- Implementação e teste integrado da API.

A formalização do contrato e do simulador não significa que o endpoint PHP ou a persistência estejam implementados.
