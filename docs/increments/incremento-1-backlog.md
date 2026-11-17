# Incremento 1 — Comunicação e coleta de dados

**Objetivo:** estabelecer a comunicação entre dispositivo/simulador e API.

**Fluxo esperado:** Dispositivo/Simulador → Comunicação → API REST PHP 8.

**Escopo confirmado pela especificação-base:**
- Criar ou configurar simulador.
- Definir mensagens de telemetria.
- Implementar recebimento na API.
- Validar dados recebidos.
- Testar a comunicação.

## Backlog proposto

| Ordem | Item | Resultado esperado | Dependência / observação |
|---|---|---|---|
| 1 | Consultar contrato oficial SmartCity Lab | Requisitos de integração identificados e divergências registradas | Bloqueador para fechar o contrato |
| 2 | Registrar decisão de protocolo e autenticação | Decisão humana documentada | Não assumir HTTP/MQTT nem credencial |
| 3 | Especificar contrato de telemetria | Campos, tipos, unidades, identificação, timestamp e validações documentados | Provisório até confirmação oficial |
| 4 | Preparar esqueleto mínimo da API PHP 8 | Aplicação executável e ponto de entrada REST | Framework permanece pendente |
| 5 | Implementar recebimento de telemetria | Endpoint recebe requisição conforme contrato aprovado/provisório | Sem persistência neste incremento, salvo decisão explícita |
| 6 | Validar mensagens no servidor | Mensagens inválidas são rejeitadas e não tratadas como medições válidas | Não criar limites clínicos |
| 7 | Implementar simulador IoT | Envio de cenários válidos, anômalos e inválidos | Seguir o mesmo contrato |
| 8 | Integrar simulador e API | Fluxo de comunicação demonstrável | Protocolo depende da decisão |
| 9 | Criar testes de comunicação e validação | Evidências de sucesso, rejeição e falhas | QA revisa |
| 10 | Documentar execução e limitações | Guia reproduzível do fluxo | DevOps/documentação |

## Critérios de aceite do incremento

- [ ] O simulador produz mensagens compatíveis com o contrato acordado.
- [ ] A API PHP 8 recebe mensagens pelo protocolo aprovado.
- [ ] A API valida os dados no servidor antes de tratá-los como válidos.
- [ ] Mensagens inválidas não são aceitas como medições válidas.
- [ ] Falhas de comunicação e erros de validação são identificáveis/registrados.
- [ ] Há testes executados para cenários válidos, inválidos e falhas de comunicação.
- [ ] O contrato e a forma de execução estão documentados.
- [ ] A solução permanece compatível com o contrato comum do SmartCity Lab.
- [ ] QA revisou os resultados e a equipe humana validou decisões pendentes relevantes.

## Fora do escopo deste incremento

- Persistência definitiva e histórico em MariaDB (Incremento 2).
- Regras clínicas e limites de alerta não aprovados.
- Funcionalidades de IA.
- Autenticação final de dispositivos antes da decisão de segurança correspondente.

## Riscos e bloqueios

1. O contrato oficial SmartCity Lab ainda não foi fornecido.
2. HTTP, MQTT ou ambos ainda não foram escolhidos.
3. Campos, unidades, identificação do dispositivo e timestamp precisam ser confirmados.
4. Autenticação, retentativas, QoS e tratamento de duplicidade dependem do protocolo/contrato.

Não tratar exemplos técnicos como decisões oficiais.
