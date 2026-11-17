# Simulador da SmartBand

O arquivo [simulador-smartband.html](simulador-smartband.html) representa um único dispositivo SmartBand do Saúde Conectada.

## Execução

1. Abra o HTML em um navegador moderno.
2. Inicie a API PHP 8 com a rota `POST /api/v1/telemetry`.
3. Ajuste o endpoint no campo correspondente para a URL real da API.
4. Configure CORS no backend para permitir a origem do simulador, se necessário.
5. Envie uma leitura ou inicie a simulação automática.

## Comportamento

- Identificador único constante: `smartband-01`.
- Cada requisição contém uma medição ou evento.
- A pressão arterial é enviada como um único objeto com `systolic` e `diastolic`.
- Valores numéricos são JSON number; pressão é object; eventos são boolean.
- A simulação automática alterna entre as seis métricas.
- Envio HTTP POST real por `fetch`; o log apresenta a resposta HTTP recebida ou falha de rede/CORS.

## Limitações e segurança

- O endpoint padrão `http://localhost:8000/api/v1/telemetry` é apenas um valor inicial; confirme a URL real.
- O backend precisa estar implementado e em execução. Este HTML não cria a API.
- O simulador não persiste dados no MariaDB. Uma resposta HTTP de sucesso não deve ser descrita como persistência sem confirmação explícita do backend.
- Autenticação do dispositivo, gestão segura de credenciais e HTTPS em ambientes publicados permanecem pendentes. Não colocar segredos no HTML/JavaScript.
- Os dados são fictícios e não definem limites clínicos.
- O contrato de referência está em [telemetry-v1.md](../../docs/contracts/telemetry-v1.md).
