# Simulador IoT — SmartBand

O projeto utilizará um único simulador que representa uma SmartBand e reúne dados de diferentes sensores. Não serão criados simuladores independentes para cada sensor neste incremento.

## Fluxo

O simulador envia as mensagens diretamente à API REST PHP 8, sem intermediador. O backend é responsável por receber e validar os dados.

## Tipos de dados simulados

Os cenários podem representar medições de oxigenação, temperatura, frequência cardíaca, pressão arterial, além de eventos como queda e acionamento do botão de auxílio, conforme o escopo de sensores confirmado no projeto.

## Cenários mínimos

- Mensagem válida.
- Mensagem com valores/tipos inválidos.
- Mensagem incompleta ou malformada.
- Falha de comunicação (timeout, indisponibilidade ou resposta de erro).

## Restrições

- Usar apenas dados fictícios.
- Não inventar limites clínicos.
- Utilizar o contrato interno versionado em `docs/contracts/`.
- Não implementar intermediador no fluxo planejado.
- Não manter um formato divergente do contrato consumido pela API.

A implementação será detalhada na Issue do simulador do Incremento 1.
