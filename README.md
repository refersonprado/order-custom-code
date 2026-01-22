# Certisign Order Custom Code

Este módulo para Magento 2 gera automaticamente um código identificador personalizado (`custom_code`) para cada pedido realizado na loja. O código é persistido na base de dados e disponibilizado para visualização no frontend, painel administrativo e via API.

## Funcionalidades

* **Geração Automática**: O código é gerado durante o checkout através do evento `sales_order_place_before`.
* **Lógica de Composição**: O identificador segue o padrão `{Prefixo}-{AnoMês}-{IncrementId}-{QuantidadeTotal}`.
* **Configuração Flexível**: Ativação e definição de prefixo via Admin.
* **Visibilidade**:
    * Exibição na página de sucesso do checkout.
    * Coluna dedicada na grid de pedidos (Sales Grid).
    * Bloco informativo no detalhe do pedido no Admin.
* **Retroatividade**: Comando de console para popular pedidos antigos.

## Instalação

### Via Composer (Recomendado)

1.  No terminal, execute:
    ```bash
    composer require refersonprado/order-custom-code
    ```
    *(Nota: Requer que o repositório esteja configurado no teu composer.json)*.
2.  Atualize os módulos:
    ```bash
    bin/magento setup:upgrade
    ```

### Via app/code (Manual)

1.  Cria a estrutura de pastas: `app/code/Certisign/OrderCustomCode`.
2.  Copie todos os arquivos do módulo para este diretório.
3.  Execute os seguintes comandos do Magento:
    ```bash
    bin/magento module:enable Certisign_OrderCustomCode
    bin/magento setup:upgrade
    bin/magento setup:di:compile
    bin/magento setup:static-content:deploy    

## Configuração

1.  Navegue até **Lojas** > **Configuração** > **Certisign** > **Order Custom Code**.
2.  **Enable**: Ativa a funcionalidade.
3.  **Prefix**: Define o prefixo desejado (ex: VAL).

## Comandos CLI

Para gerar códigos para pedidos que foram criados antes da instalação do módulo, utilize o comando:

```bash
bin/magento certisign:order:populate-custom-code
