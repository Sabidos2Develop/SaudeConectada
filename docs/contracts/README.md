# Contratos internos

Os contratos compartilhados entre os componentes do Saúde Conectada devem ser definidos, documentados e versionados nesta pasta.

## Telemetria da SmartBand

O contrato de telemetria é interno ao Saúde Conectada. A equipe de arquitetura é responsável por propor e documentar uma estrutura padronizada, compartilhada pelo simulador único da SmartBand e pela API PHP 8.

### Contexto confirmado

- Um único simulador representa a SmartBand.
- A SmartBand reúne medições de diferentes sensores.
- O simulador envia os dados diretamente à API, sem intermediador.
- A API recebe e valida as mensagens.
- Não existe integração nem contrato técnico externo do SmartCity Lab.

### Elementos que o contrato deverá especificar

- Identificação do dispositivo (SmartBand).
- Identificação de cada tipo de medição/sensor.
- Valor e unidade de medida.
- Instante da medição e formato de data/hora.
- Tipos, obrigatoriedade e regras de validação dos campos.
- Versão do contrato.
- Envelope da mensagem e se cada envio pode conter uma ou várias medições.
- Exemplos fictícios válidos e inválidos.

A definição do envelope e da quantidade de medições por mensagem permanece pendente de decisão técnica. Não assumir que todas as medições precisam estar no mesmo payload apenas porque pertencem ao mesmo dispositivo.

## Evolução

Toda alteração incompatível deve ser identificada e documentada. Simulador e API devem evoluir de forma coordenada para manter compatibilidade interna.
