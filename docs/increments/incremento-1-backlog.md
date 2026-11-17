# Incremento 1 — Comunicação e coleta de dados

**Objetivo:** estabelecer e testar o fluxo de telemetria entre o simulador único da SmartBand e a API REST PHP 8.

**Fluxo confirmado:** Simulador SmartBand → comunicação direta (sem intermediador) → API REST PHP 8.

**Responsabilidade:** a arquitetura do Saúde Conectada define o contrato interno padronizado; o backend recebe e valida as mensagens.

## Escopo confirmado

- Um único simulador representa uma SmartBand que reúne medições de diferentes sensores.
- O simulador envia telemetria diretamente à API.
- A API é responsável pelo recebimento e validação.
- O contrato de dados é interno ao Saúde Conectada.
- Não há integração técnica externa com SmartCity Lab.

## Backlog proposto

| Ordem | Item | Resultado esperado | Dependência / observação |
|---|---|---|---|
| 1 | Definir contrato interno de telemetria | Campos, tipos, unidades, identificação, timestamp e validações documentados | Responsabilidade da arquitetura |
| 2 | Registrar decisão de protocolo e segurança | Comunicação direta simulador → API definida e aprovada | Considerar HTTP como caminho natural para API REST; avaliar necessidade real de MQTT |
| 3 | Preparar esqueleto mínimo da API PHP 8 | Aplicação executável e ponto de entrada REST | Framework permanece pendente |
| 4 | Implementar recebimento de telemetria | Endpoint recebe requisição conforme contrato interno | Sem persistência definitiva neste incremento |
| 5 | Validar mensagens no servidor | Mensagens inválidas são rejeitadas e não tratadas como medições válidas | Não criar limites clínicos |
| 6 | Implementar simulador único da SmartBand | Cenários de diferentes sensores e envio direto à API | Seguir o mesmo contrato |
| 7 | Integrar simulador e API | Fluxo direto demonstrável, sem intermediador | Protocolo depende da decisão |
| 8 | Criar testes de comunicação e validação | Evidências de sucesso, rejeição e falhas | QA revisa |
| 9 | Documentar execução e limitações | Guia reproduzível do fluxo | DevOps/documentação |

## Critérios de aceite do incremento

- [ ] Existe um simulador único representando a SmartBand.
- [ ] O simulador gera dados fictícios de diferentes tipos de medição.
- [ ] O simulador envia diretamente à API, sem intermediador.
- [ ] Simulador e API utilizam a mesma versão documentada do contrato interno.
- [ ] A API PHP 8 recebe mensagens pelo protocolo aprovado.
- [ ] A API valida os dados no servidor antes de tratá-los como válidos.
- [ ] Mensagens inválidas não são aceitas como medições válidas.
- [ ] Falhas de comunicação e erros de validação são identificáveis.
- [ ] Há testes executados para cenários válidos, inválidos e falhas de comunicação.
- [ ] O contrato e a forma de execução estão documentados.
- [ ] QA revisou os resultados e decisões pendentes relevantes foram validadas pela equipe.

## Fora do escopo deste incremento

- Persistência definitiva e histórico em MariaDB (Incremento 2).
- Regras clínicas e limites de alerta não aprovados.
- Funcionalidades de IA.
- Autenticação final do dispositivo antes da decisão de segurança correspondente.

## Riscos e decisões pendentes

1. Protocolo de comunicação direta e mecanismo de segurança ainda precisam ser registrados.
2. O contrato precisa definir se cada requisição transporta várias medições ou uma medição por mensagem.
3. Campos, tipos, unidades, identificação do dispositivo e timestamp precisam ser especificados.
4. Autenticação, retentativas e tratamento de duplicidade dependem das decisões de protocolo e contrato.

Não existe dependência de contrato, aprovação ou integração externa do SmartCity Lab.
