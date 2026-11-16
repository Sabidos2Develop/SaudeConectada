# Simulador IoT

O simulador deve representar um dispositivo IoT e produzir mensagens de telemetria compatíveis com o contrato acordado para o Saúde Conectada.

## Cenários mínimos

- Mensagem válida.
- Mensagem com valores/tipos inválidos.
- Mensagem incompleta ou malformada.
- Falha de comunicação (timeout, indisponibilidade ou resposta de erro).

## Restrições

- Usar apenas dados fictícios.
- Não inventar limites clínicos.
- Não fixar protocolo antes da decisão registrada.
- Não manter um formato divergente do contrato consumido pela API.

A implementação será detalhada na Issue do simulador do Incremento 1.
