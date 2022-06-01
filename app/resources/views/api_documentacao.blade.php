<!doctype html>
<html>
  <head>
    <title>EcoSmart Store API</title>
    <style type="text/css">
      body {
      	font-family: Trebuchet MS, sans-serif;
      	font-size: 15px;
      	color: #444;
      	margin-right: 24px;
      }
      
      h1	{
      	font-size: 25px;
      }
      h2	{
      	font-size: 20px;
      }
      h3	{
      	font-size: 16px;
      	font-weight: bold;
      }
      hr	{
      	height: 1px;
      	border: 0;
      	color: #ddd;
      	background-color: #ddd;
      }
      
      .app-desc {
        clear: both;
        margin-left: 20px;
      }
      .param-name {
        width: 100%;
      }
      .license-info {
        margin-left: 20px;
      }
      
      .license-url {
        margin-left: 20px;
      }
      
      .model {
        margin: 0 0 0px 20px;
      }
      
      .method {
        margin-left: 20px;
      }
      
      .method-notes	{
      	margin: 10px 0 20px 0;
      	font-size: 90%;
      	color: #555;
      }
      
      pre {
        padding: 10px;
        margin-bottom: 2px;
      }
      
      .http-method {
       text-transform: uppercase;
      }
      
      pre.get {
        background-color: #0f6ab4;
      }
      
      pre.post {
        background-color: #10a54a;
      }
      
      pre.put {
        background-color: #c5862b;
      }
      
      pre.delete {
        background-color: #a41e22;
      }
      
      .huge	{
      	color: #fff;
      }
      
      pre.example {
        background-color: #f3f3f3;
        padding: 10px;
        border: 1px solid #ddd;
      }
      
      code {
        white-space: pre;
      }
      
      .nickname {
        font-weight: bold;
      }
      
      .method-path {
        font-size: 1.5em;
        background-color: #0f6ab4;
      }
      
      .up {
        float:right;
      }
      
      .parameter {
        width: 500px;
      }
      
      .param {
        width: 500px;
        padding: 10px 0 0 20px;
        font-weight: bold;
      }
      
      .param-desc {
        width: 700px;
        padding: 0 0 0 20px;
        color: #777;
      }
      
      .param-type {
        font-style: italic;
      }
      
      .param-enum-header {
      width: 700px;
      padding: 0 0 0 60px;
      color: #777;
      font-weight: bold;
      }
      
      .param-enum {
      width: 700px;
      padding: 0 0 0 80px;
      color: #777;
      font-style: italic;
      }
      
      .field-label {
        padding: 0;
        margin: 0;
        clear: both;
      }
      
      .field-items	{
      	padding: 0 0 15px 0;
      	margin-bottom: 15px;
      }
      
      .return-type {
        clear: both;
        padding-bottom: 10px;
      }
      
      .param-header {
        font-weight: bold;
      }
      
      .method-tags {
        text-align: right;
      }
      
      .method-tag {
        background: none repeat scroll 0% 0% #24A600;
        border-radius: 3px;
        padding: 2px 10px;
        margin: 2px;
        color: #FFF;
        display: inline-block;
        text-decoration: none;
      }
    </style>
  </head>
  <body>
  <h1>EcoSmart Store API</h1>
    <div class="app-desc">API desenvolvida por António Pereira, aluno 54956 / Francisco Pimenta, aluno 54973 / Miguel Duarte, aluno54941 / Pedro Quintão, aluno 54971 / Rafael Ribeiro, aluno 54960.
Com esta API é possível visualizar e manipular recursos da aplicação EcoSmart Store, nomeadamente clientes, fornecedores, transportadoras, produtos, encomendas...</div>
    <div class="app-desc">More information: <a href="https://helloreverb.com">https://helloreverb.com</a></div>
    <div class="app-desc">Contact Info: <a href="ecosmartstore@gmail.com">ecosmartstore@gmail.com</a></div>
    <div class="app-desc">Version: 3.0.0</div>
    
    <div class="license-info">All rights reserved</div>
    <div class="license-url">http://apache.org/licenses/LICENSE-2.0.html</div>
  <h2>Access</h2>
    <ol>
      <li>OAuth AuthorizationUrl:https://asustainablemarketplace.com/oauth/authorizeTokenUrl:https://asustainablemarketplace.com/oauth/token</li>
    </ol>

  <h2><a name="__Methods">Methods</a></h2>
  [ Jump to <a href="#__Models">Models</a> ]

  <h3>Table of Contents </h3>
  <div class="method-summary"></div>
  <h4><a href="#Consumidor">Consumidor</a></h4>
  <ul>
  <li><a href="#createConsumer"><code><span class="http-method">post</span> /consumidores</code></a></li>
  <li><a href="#deleteConsumer"><code><span class="http-method">delete</span> /consumidores/{consumidorId}</code></a></li>
  <li><a href="#deleteConsumerOrder"><code><span class="http-method">delete</span> /consumidores/{consumidorId}/encomendas/{encomendaId}</code></a></li>
  <li><a href="#getAllConsumerOrders"><code><span class="http-method">get</span> /consumidores/{consumidorId}/encomendas</code></a></li>
  <li><a href="#getAllConsumers"><code><span class="http-method">get</span> /consumidores</code></a></li>
  <li><a href="#getUniqueConsumer"><code><span class="http-method">get</span> /consumidores/{consumidorId}</code></a></li>
  <li><a href="#getUniqueConsumerOrder"><code><span class="http-method">get</span> /consumidores/{consumidorId}/encomendas/{encomendaId}</code></a></li>
  <li><a href="#newConsumerOrder"><code><span class="http-method">post</span> /consumidores/{consumidorId}/encomendas</code></a></li>
  <li><a href="#updateConsumer"><code><span class="http-method">put</span> /consumidores/{consumidorId}</code></a></li>
  </ul>
  <h4><a href="#Fornecedor">Fornecedor</a></h4>
  <ul>
  <li><a href="#addProductToInventory"><code><span class="http-method">post</span> /fornecedores/{fornecedorId}/produto</code></a></li>
  <li><a href="#createProvider"><code><span class="http-method">post</span> /fornecedores</code></a></li>
  <li><a href="#createWarehouse"><code><span class="http-method">post</span> /fornecedores/{fornecedorId}/armazem</code></a></li>
  <li><a href="#createWarehouseProduct"><code><span class="http-method">post</span> /fornecedores/{fornecedorId}/armazem/{armazemId}/produto</code></a></li>
  <li><a href="#deleteInventoryUniqueProduct"><code><span class="http-method">delete</span> /fornecedores/{fornecedorId}/produto/{produtoId}</code></a></li>
  <li><a href="#deleteOrder"><code><span class="http-method">delete</span> /fornecedores/{fornecedorId}/encomendas/{encomendaId}</code></a></li>
  <li><a href="#deleteProvider"><code><span class="http-method">delete</span> /fornecedores/{fornecedorId}</code></a></li>
  <li><a href="#deleteWarehouse"><code><span class="http-method">delete</span> /fornecedores/{fornecedorId}/armazem/{armazemId}</code></a></li>
  <li><a href="#getAllOrders"><code><span class="http-method">get</span> /fornecedores/{fornecedorId}/encomendas</code></a></li>
  <li><a href="#getAllProviders"><code><span class="http-method">get</span> /fornecedores</code></a></li>
  <li><a href="#getAllWareHouses"><code><span class="http-method">get</span> /fornecedores/{fornecedorId}/armazem</code></a></li>
  <li><a href="#getAllWarehouseProducts"><code><span class="http-method">get</span> /fornecedores/{fornecedorId}/armazem/{armazemId}/produto</code></a></li>
  <li><a href="#getInventory"><code><span class="http-method">get</span> /fornecedores/{fornecedorId}/produto</code></a></li>
  <li><a href="#getInventoryUniqueProduct"><code><span class="http-method">get</span> /fornecedores/{fornecedorId}/produto/{produtoId}</code></a></li>
  <li><a href="#getUniqueOrder"><code><span class="http-method">get</span> /fornecedores/{fornecedorId}/encomendas/{encomendaId}</code></a></li>
  <li><a href="#getUniqueProvider"><code><span class="http-method">get</span> /fornecedores/{fornecedorId}</code></a></li>
  <li><a href="#getUniqueWarehouse"><code><span class="http-method">get</span> /fornecedores/{fornecedorId}/armazem/{armazemId}</code></a></li>
  <li><a href="#updateProductInInventory"><code><span class="http-method">put</span> /fornecedores/{fornecedorId}/produto/{produtoId}</code></a></li>
  <li><a href="#updateProviderInfos"><code><span class="http-method">put</span> /fornecedores/{fornecedorId}</code></a></li>
  <li><a href="#updateWarehouse"><code><span class="http-method">put</span> /fornecedores/{fornecedorId}/armazem/{armazemId}</code></a></li>
  </ul>
  <h4><a href="#Transportadora">Transportadora</a></h4>
  <ul>
  <li><a href="#createShippingBase"><code><span class="http-method">post</span> /transportadoras/{transportadoraId}/bases</code></a></li>
  <li><a href="#createTransporter"><code><span class="http-method">post</span> /transportadoras</code></a></li>
  <li><a href="#deleteShippingBase"><code><span class="http-method">delete</span> /transportadoras/{transportadoraId}/bases/{baseID}</code></a></li>
  <li><a href="#deleteShippingCompany"><code><span class="http-method">delete</span> /transportadoras/{transportadoraId}</code></a></li>
  <li><a href="#getAllShippingCompany"><code><span class="http-method">get</span> /transportadoras</code></a></li>
  <li><a href="#getShippingBase"><code><span class="http-method">get</span> /transportadoras/{transportadoraId}/bases/{baseID}</code></a></li>
  <li><a href="#getShippingBases"><code><span class="http-method">get</span> /transportadoras/{transportadoraId}/bases</code></a></li>
  <li><a href="#getUniqueShippingCompany"><code><span class="http-method">get</span> /transportadoras/{transportadoraId}</code></a></li>
  <li><a href="#updateShippingBase"><code><span class="http-method">put</span> /transportadoras/{transportadoraId}/bases/{baseID}</code></a></li>
  <li><a href="#updateShippingCompany"><code><span class="http-method">put</span> /transportadoras/{transportadoraId}</code></a></li>
  </ul>

  <h1><a name="Consumidor">Consumidor</a></h1>
  <div class="method"><a name="createConsumer"></a>
    <div class="method-path">
    <a class="up" href="#__Methods">Up</a>
    <pre class="post"><code class="huge"><span class="http-method">post</span> /consumidores</code></pre></div>
    <div class="method-summary">Adiciona um novo Consumidor (<span class="nickname">createConsumer</span>)</div>
    <div class="method-notes"></div>


    <h3 class="field-label">Consumes</h3>
    This API call consumes the following media types via the <span class="header">Content-Type</span> request header:
    <ul>
      <li><code>application/json</code></li>
    </ul>

    <h3 class="field-label">Request body</h3>
    <div class="field-items">
      <div class="param">body <a href="#Consumidor">Consumidor</a> (optional)</div>
      
            <div class="param-desc"><span class="param-type">Body Parameter</span> &mdash;  </div>
            <div class="param-desc"><span class="param-type">example: <code>{
  &quot;nome&quot; : &quot;Jéssica Antunes&quot;,
  &quot;email&quot; : &quot;jess@gmail.com&quot;,
  &quot;password&quot; : &quot;jess123&quot;,
  &quot;morada&quot; : &quot;Rua de Cabo Verde 5, Amadora&quot;,
  &quot;nif&quot; : 123456789,
  &quot;telefone&quot; : 987654321
}</code></span></div>    </div>  <!-- field-items -->





    <!--Todo: process Response Object and its headers, schema, examples -->



    <h3 class="field-label">Responses</h3>
    <h4 class="field-label">201</h4>
    Fornecedor criado
        <a href="#"></a>
    <h4 class="field-label">400</h4>
    O servidor não consegue ou não irá processar o pedido devido a um erro por parte do cliente.
        <a href="#"></a>
  </div> <!-- method -->
  <hr/>
  <div class="method"><a name="deleteConsumer"></a>
    <div class="method-path">
    <a class="up" href="#__Methods">Up</a>
    <pre class="delete"><code class="huge"><span class="http-method">delete</span> /consumidores/{consumidorId}</code></pre></div>
    <div class="method-summary">Apagar a conta de um consumidor (<span class="nickname">deleteConsumer</span>)</div>
    <div class="method-notes">Esta operação só pode ser realizada por um utilizador autenticado</div>

    <h3 class="field-label">Path parameters</h3>
    <div class="field-items">
      <div class="param">consumidorId (required)</div>
      
            <div class="param-desc"><span class="param-type">Path Parameter</span> &mdash; O id da conta do consumidor que vai ser apagada </div>    </div>  <!-- field-items -->







    <!--Todo: process Response Object and its headers, schema, examples -->



    <h3 class="field-label">Responses</h3>
    <h4 class="field-label">200</h4>
    successful operation
        <a href="#"></a>
    <h4 class="field-label">400</h4>
    consumidorId inválido
        <a href="#"></a>
    <h4 class="field-label">401</h4>
    Utilizador não pode apagar o consumidor
        <a href="#"></a>
    <h4 class="field-label">404</h4>
    consumidorId não encontrado
        <a href="#"></a>
  </div> <!-- method -->
  <hr/>
  <div class="method"><a name="deleteConsumerOrder"></a>
    <div class="method-path">
    <a class="up" href="#__Methods">Up</a>
    <pre class="delete"><code class="huge"><span class="http-method">delete</span> /consumidores/{consumidorId}/encomendas/{encomendaId}</code></pre></div>
    <div class="method-summary">Apagar a encomenda de um consumidor (<span class="nickname">deleteConsumerOrder</span>)</div>
    <div class="method-notes">Esta operação só pode ser realizada por um utilizador autenticado</div>

    <h3 class="field-label">Path parameters</h3>
    <div class="field-items">
      <div class="param">consumidorId (required)</div>
      
            <div class="param-desc"><span class="param-type">Path Parameter</span> &mdash; O Id da conta do consumidor </div>      <div class="param">encomendaId (required)</div>
      
            <div class="param-desc"><span class="param-type">Path Parameter</span> &mdash; O ID da encomenda do consumidor que vai ser apagada format: int64</div>    </div>  <!-- field-items -->







    <!--Todo: process Response Object and its headers, schema, examples -->



    <h3 class="field-label">Responses</h3>
    <h4 class="field-label">400</h4>
    consumidorId/encomendaId inválido
        <a href="#"></a>
    <h4 class="field-label">401</h4>
    Utilizador não pode apagar a encomenda do consumidor
        <a href="#"></a>
    <h4 class="field-label">404</h4>
    consumidor/encomendaId não encontrado
        <a href="#"></a>
  </div> <!-- method -->
  <hr/>
  <div class="method"><a name="getAllConsumerOrders"></a>
    <div class="method-path">
    <a class="up" href="#__Methods">Up</a>
    <pre class="get"><code class="huge"><span class="http-method">get</span> /consumidores/{consumidorId}/encomendas</code></pre></div>
    <div class="method-summary"> (<span class="nickname">getAllConsumerOrders</span>)</div>
    <div class="method-notes">Devolve as encomendas de um dado consumidor</div>

    <h3 class="field-label">Path parameters</h3>
    <div class="field-items">
      <div class="param">consumidorId (required)</div>
      
            <div class="param-desc"><span class="param-type">Path Parameter</span> &mdash; ID do consumidor format: int64</div>    </div>  <!-- field-items -->






    <h3 class="field-label">Return type</h3>
    <div class="return-type">
      array[<a href="#Encomenda">Encomenda</a>]
      
    </div>

    <!--Todo: process Response Object and its headers, schema, examples -->

    <h3 class="field-label">Example data</h3>
    <div class="example-data-content-type">Content-Type: application/json</div>
    <pre class="example"><code>[ {
  "Morada de Entrega" : "Morada de Entrega",
  "Preço" : 6,
  "Data Realizada" : "2000-01-23",
  "Produto ID" : 5,
  "EstadoDaEncomenda" : "confirmada",
  "Consumidor ID" : 5,
  "ID" : 0,
  "Data Finalizada" : "2000-01-23",
  "Transportadora ID" : 2,
  "Quantidade" : 1
}, {
  "Morada de Entrega" : "Morada de Entrega",
  "Preço" : 6,
  "Data Realizada" : "2000-01-23",
  "Produto ID" : 5,
  "EstadoDaEncomenda" : "confirmada",
  "Consumidor ID" : 5,
  "ID" : 0,
  "Data Finalizada" : "2000-01-23",
  "Transportadora ID" : 2,
  "Quantidade" : 1
} ]</code></pre>

    <h3 class="field-label">Produces</h3>
    This API call produces the following media types according to the <span class="header">Accept</span> request header;
    the media type will be conveyed by the <span class="header">Content-Type</span> response header.
    <ul>
      <li><code>application/json</code></li>
    </ul>

    <h3 class="field-label">Responses</h3>
    <h4 class="field-label">200</h4>
    successful operation
        
    <h4 class="field-label">400</h4>
    consumidorId inválido
        <a href="#"></a>
    <h4 class="field-label">401</h4>
    Utilizador não pode visualizar as encomendas que o consumidor possui
        <a href="#"></a>
    <h4 class="field-label">404</h4>
    consumidorId não encontrado
        <a href="#"></a>
  </div> <!-- method -->
  <hr/>
  <div class="method"><a name="getAllConsumers"></a>
    <div class="method-path">
    <a class="up" href="#__Methods">Up</a>
    <pre class="get"><code class="huge"><span class="http-method">get</span> /consumidores</code></pre></div>
    <div class="method-summary">Lista dos consumidores. (<span class="nickname">getAllConsumers</span>)</div>
    <div class="method-notes">Devolve uma lista com todos os consumidores.</div>







    <h3 class="field-label">Return type</h3>
    <div class="return-type">
      array[<a href="#Consumidor">Consumidor</a>]
      
    </div>

    <!--Todo: process Response Object and its headers, schema, examples -->

    <h3 class="field-label">Example data</h3>
    <div class="example-data-content-type">Content-Type: application/json</div>
    <pre class="example"><code>[ {
  "Email" : "Email",
  "Morada" : "Morada",
  "Telefone" : 111111111,
  "NIF" : 111111111,
  "ID" : 1,
  "Nome" : "Nome",
  "Password" : "Password"
}, {
  "Email" : "Email",
  "Morada" : "Morada",
  "Telefone" : 111111111,
  "NIF" : 111111111,
  "ID" : 1,
  "Nome" : "Nome",
  "Password" : "Password"
} ]</code></pre>

    <h3 class="field-label">Produces</h3>
    This API call produces the following media types according to the <span class="header">Accept</span> request header;
    the media type will be conveyed by the <span class="header">Content-Type</span> response header.
    <ul>
      <li><code>application/json</code></li>
    </ul>

    <h3 class="field-label">Responses</h3>
    <h4 class="field-label">200</h4>
    successful operation
        
    <h4 class="field-label">404</h4>
    Não foram encontrados consumidores
        <a href="#"></a>
  </div> <!-- method -->
  <hr/>
  <div class="method"><a name="getUniqueConsumer"></a>
    <div class="method-path">
    <a class="up" href="#__Methods">Up</a>
    <pre class="get"><code class="huge"><span class="http-method">get</span> /consumidores/{consumidorId}</code></pre></div>
    <div class="method-summary">Encontra um consumidor pelo ID (<span class="nickname">getUniqueConsumer</span>)</div>
    <div class="method-notes">Devolve todas as informações de um consumidor</div>

    <h3 class="field-label">Path parameters</h3>
    <div class="field-items">
      <div class="param">consumidorId (required)</div>
      
            <div class="param-desc"><span class="param-type">Path Parameter</span> &mdash; O consumidor do qual se quer informações. format: int64</div>    </div>  <!-- field-items -->






    <h3 class="field-label">Return type</h3>
    <div class="return-type">
      <a href="#Consumidor">Consumidor</a>
      
    </div>

    <!--Todo: process Response Object and its headers, schema, examples -->

    <h3 class="field-label">Example data</h3>
    <div class="example-data-content-type">Content-Type: application/json</div>
    <pre class="example"><code>{
  "Email" : "Email",
  "Morada" : "Morada",
  "Telefone" : 111111111,
  "NIF" : 111111111,
  "ID" : 1,
  "Nome" : "Nome",
  "Password" : "Password"
}</code></pre>

    <h3 class="field-label">Produces</h3>
    This API call produces the following media types according to the <span class="header">Accept</span> request header;
    the media type will be conveyed by the <span class="header">Content-Type</span> response header.
    <ul>
      <li><code>application/json</code></li>
    </ul>

    <h3 class="field-label">Responses</h3>
    <h4 class="field-label">200</h4>
    successful operation
        <a href="#Consumidor">Consumidor</a>
    <h4 class="field-label">400</h4>
    consumidorId inválido
        <a href="#"></a>
    <h4 class="field-label">401</h4>
    Utilizador não pode visualizar informações sobre o consumidor
        <a href="#"></a>
    <h4 class="field-label">404</h4>
    Consumidor não encontrado
        <a href="#"></a>
  </div> <!-- method -->
  <hr/>
  <div class="method"><a name="getUniqueConsumerOrder"></a>
    <div class="method-path">
    <a class="up" href="#__Methods">Up</a>
    <pre class="get"><code class="huge"><span class="http-method">get</span> /consumidores/{consumidorId}/encomendas/{encomendaId}</code></pre></div>
    <div class="method-summary">Encontra a encomenda de um consumidor (<span class="nickname">getUniqueConsumerOrder</span>)</div>
    <div class="method-notes">Devolve todas as informações da encomenda de um consumidor</div>

    <h3 class="field-label">Path parameters</h3>
    <div class="field-items">
      <div class="param">consumidorId (required)</div>
      
            <div class="param-desc"><span class="param-type">Path Parameter</span> &mdash; ID do consumidor format: int64</div>      <div class="param">encomendaId (required)</div>
      
            <div class="param-desc"><span class="param-type">Path Parameter</span> &mdash; A encomenda do consumidor da qual se quer informações. format: int64</div>    </div>  <!-- field-items -->






    <h3 class="field-label">Return type</h3>
    <div class="return-type">
      <a href="#Encomenda">Encomenda</a>
      
    </div>

    <!--Todo: process Response Object and its headers, schema, examples -->

    <h3 class="field-label">Example data</h3>
    <div class="example-data-content-type">Content-Type: application/json</div>
    <pre class="example"><code>{
  "Morada de Entrega" : "Morada de Entrega",
  "Preço" : 6,
  "Data Realizada" : "2000-01-23",
  "Produto ID" : 5,
  "EstadoDaEncomenda" : "confirmada",
  "Consumidor ID" : 5,
  "ID" : 0,
  "Data Finalizada" : "2000-01-23",
  "Transportadora ID" : 2,
  "Quantidade" : 1
}</code></pre>

    <h3 class="field-label">Produces</h3>
    This API call produces the following media types according to the <span class="header">Accept</span> request header;
    the media type will be conveyed by the <span class="header">Content-Type</span> response header.
    <ul>
      <li><code>application/json</code></li>
    </ul>

    <h3 class="field-label">Responses</h3>
    <h4 class="field-label">200</h4>
    successful operation
        <a href="#Encomenda">Encomenda</a>
    <h4 class="field-label">400</h4>
    consumidorId inválido
        <a href="#"></a>
    <h4 class="field-label">401</h4>
    Utilizador não pode visualizar informações sobre o consumidor
        <a href="#"></a>
    <h4 class="field-label">404</h4>
    Consumidor não encontrado
        <a href="#"></a>
  </div> <!-- method -->
  <hr/>
  <div class="method"><a name="newConsumerOrder"></a>
    <div class="method-path">
    <a class="up" href="#__Methods">Up</a>
    <pre class="post"><code class="huge"><span class="http-method">post</span> /consumidores/{consumidorId}/encomendas</code></pre></div>
    <div class="method-summary"> (<span class="nickname">newConsumerOrder</span>)</div>
    <div class="method-notes">Cria uma nova encomenda</div>

    <h3 class="field-label">Path parameters</h3>
    <div class="field-items">
      <div class="param">consumidorId (required)</div>
      
            <div class="param-desc"><span class="param-type">Path Parameter</span> &mdash; ID do consumidor </div>    </div>  <!-- field-items -->

    <h3 class="field-label">Consumes</h3>
    This API call consumes the following media types via the <span class="header">Content-Type</span> request header:
    <ul>
      <li><code>application/json</code></li>
    </ul>

    <h3 class="field-label">Request body</h3>
    <div class="field-items">
      <div class="param">body <a href="#Encomenda">Encomenda</a> (optional)</div>
      
            <div class="param-desc"><span class="param-type">Body Parameter</span> &mdash;  </div>
                </div>  <!-- field-items -->





    <!--Todo: process Response Object and its headers, schema, examples -->



    <h3 class="field-label">Responses</h3>
    <h4 class="field-label">201</h4>
    Encomenda criada
        <a href="#"></a>
    <h4 class="field-label">400</h4>
    Informações para a criação da encomenda inválidas
        <a href="#"></a>
    <h4 class="field-label">401</h4>
    Utilizador não pode criar a encomenda
        <a href="#"></a>
    <h4 class="field-label">404</h4>
    consumidorId não encontrado
        <a href="#"></a>
  </div> <!-- method -->
  <hr/>
  <div class="method"><a name="updateConsumer"></a>
    <div class="method-path">
    <a class="up" href="#__Methods">Up</a>
    <pre class="put"><code class="huge"><span class="http-method">put</span> /consumidores/{consumidorId}</code></pre></div>
    <div class="method-summary">Consumidor Atualizado (<span class="nickname">updateConsumer</span>)</div>
    <div class="method-notes">Atualizar todas as informações de um consumidor. Esta operação só pode ser realizada por um utilizador autenticado</div>

    <h3 class="field-label">Path parameters</h3>
    <div class="field-items">
      <div class="param">consumidorId (required)</div>
      
            <div class="param-desc"><span class="param-type">Path Parameter</span> &mdash; ID do consumidor a ser atualizado </div>    </div>  <!-- field-items -->

    <h3 class="field-label">Consumes</h3>
    This API call consumes the following media types via the <span class="header">Content-Type</span> request header:
    <ul>
      <li><code>application/json</code></li>
    </ul>

    <h3 class="field-label">Request body</h3>
    <div class="field-items">
      <div class="param">body <a href="#Consumidor">Consumidor</a> (required)</div>
      
            <div class="param-desc"><span class="param-type">Body Parameter</span> &mdash; Objeto JSON que contém a informação do cliente </div>
                </div>  <!-- field-items -->





    <!--Todo: process Response Object and its headers, schema, examples -->



    <h3 class="field-label">Responses</h3>
    <h4 class="field-label">200</h4>
    successful operation
        <a href="#"></a>
    <h4 class="field-label">400</h4>
    consumidorId inválido
        <a href="#"></a>
    <h4 class="field-label">401</h4>
    Utilizador não pode atualizar o consumidor
        <a href="#"></a>
    <h4 class="field-label">404</h4>
    consumidorId não encontrado
        <a href="#"></a>
  </div> <!-- method -->
  <hr/>
  <h1><a name="Fornecedor">Fornecedor</a></h1>
  <div class="method"><a name="addProductToInventory"></a>
    <div class="method-path">
    <a class="up" href="#__Methods">Up</a>
    <pre class="post"><code class="huge"><span class="http-method">post</span> /fornecedores/{fornecedorId}/produto</code></pre></div>
    <div class="method-summary"> (<span class="nickname">addProductToInventory</span>)</div>
    <div class="method-notes">Adicionar um produto à lista de produtos de um fornecedor</div>

    <h3 class="field-label">Path parameters</h3>
    <div class="field-items">
      <div class="param">fornecedorId (required)</div>
      
            <div class="param-desc"><span class="param-type">Path Parameter</span> &mdash; ID do fornecedor </div>    </div>  <!-- field-items -->

    <h3 class="field-label">Consumes</h3>
    This API call consumes the following media types via the <span class="header">Content-Type</span> request header:
    <ul>
      <li><code>application/json</code></li>
    </ul>

    <h3 class="field-label">Request body</h3>
    <div class="field-items">
      <div class="param">body <a href="#Produto">Produto</a> (optional)</div>
      
            <div class="param-desc"><span class="param-type">Body Parameter</span> &mdash;  </div>
                </div>  <!-- field-items -->





    <!--Todo: process Response Object and its headers, schema, examples -->



    <h3 class="field-label">Responses</h3>
    <h4 class="field-label">201</h4>
    Produto criado
        <a href="#"></a>
    <h4 class="field-label">400</h4>
    fornecedorId inválido
        <a href="#"></a>
    <h4 class="field-label">401</h4>
    Utilizador não pode criar o produto
        <a href="#"></a>
    <h4 class="field-label">404</h4>
    fornecedorId não encontrado
        <a href="#"></a>
  </div> <!-- method -->
  <hr/>
  <div class="method"><a name="createProvider"></a>
    <div class="method-path">
    <a class="up" href="#__Methods">Up</a>
    <pre class="post"><code class="huge"><span class="http-method">post</span> /fornecedores</code></pre></div>
    <div class="method-summary">Adiciona um novo fornecedor (<span class="nickname">createProvider</span>)</div>
    <div class="method-notes"></div>


    <h3 class="field-label">Consumes</h3>
    This API call consumes the following media types via the <span class="header">Content-Type</span> request header:
    <ul>
      <li><code>application/json</code></li>
    </ul>

    <h3 class="field-label">Request body</h3>
    <div class="field-items">
      <div class="param">body <a href="#Fornecedor">Fornecedor</a> (optional)</div>
      
            <div class="param-desc"><span class="param-type">Body Parameter</span> &mdash;  </div>
            <div class="param-desc"><span class="param-type">example: <code>{
  &quot;nome&quot; : &quot;Jéssica Antunes&quot;,
  &quot;email&quot; : &quot;jess@gmail.com&quot;,
  &quot;password&quot; : &quot;jess123&quot;,
  &quot;morada&quot; : &quot;Rua de Cabo Verde 5, Amadora&quot;,
  &quot;nif&quot; : 123456789,
  &quot;telefone&quot; : 987654321
}</code></span></div>    </div>  <!-- field-items -->





    <!--Todo: process Response Object and its headers, schema, examples -->



    <h3 class="field-label">Responses</h3>
    <h4 class="field-label">201</h4>
    Fornecedor criado
        <a href="#"></a>
    <h4 class="field-label">400</h4>
    O servidor não consegue ou não irá processar o pedido devido a um erro por parte do cliente.
        <a href="#"></a>
  </div> <!-- method -->
  <hr/>
  <div class="method"><a name="createWarehouse"></a>
    <div class="method-path">
    <a class="up" href="#__Methods">Up</a>
    <pre class="post"><code class="huge"><span class="http-method">post</span> /fornecedores/{fornecedorId}/armazem</code></pre></div>
    <div class="method-summary">Adiciona um armazem (<span class="nickname">createWarehouse</span>)</div>
    <div class="method-notes"></div>

    <h3 class="field-label">Path parameters</h3>
    <div class="field-items">
      <div class="param">fornecedorId (required)</div>
      
            <div class="param-desc"><span class="param-type">Path Parameter</span> &mdash;  format: int64</div>    </div>  <!-- field-items -->

    <h3 class="field-label">Consumes</h3>
    This API call consumes the following media types via the <span class="header">Content-Type</span> request header:
    <ul>
      <li><code>application/json</code></li>
    </ul>

    <h3 class="field-label">Request body</h3>
    <div class="field-items">
      <div class="param">body <a href="#Armazem">Armazem</a> (optional)</div>
      
            <div class="param-desc"><span class="param-type">Body Parameter</span> &mdash;  </div>
                </div>  <!-- field-items -->





    <!--Todo: process Response Object and its headers, schema, examples -->



    <h3 class="field-label">Responses</h3>
    <h4 class="field-label">201</h4>
    Armazem criado
        <a href="#"></a>
    <h4 class="field-label">400</h4>
    O servidor não consegue ou não irá processar o pedido devido a um erro por parte do cliente.
        <a href="#"></a>
  </div> <!-- method -->
  <hr/>
  <div class="method"><a name="createWarehouseProduct"></a>
    <div class="method-path">
    <a class="up" href="#__Methods">Up</a>
    <pre class="post"><code class="huge"><span class="http-method">post</span> /fornecedores/{fornecedorId}/armazem/{armazemId}/produto</code></pre></div>
    <div class="method-summary">Adiciona um novo produto ao armazem (<span class="nickname">createWarehouseProduct</span>)</div>
    <div class="method-notes"></div>

    <h3 class="field-label">Path parameters</h3>
    <div class="field-items">
      <div class="param">fornecedorId (required)</div>
      
            <div class="param-desc"><span class="param-type">Path Parameter</span> &mdash; ID do fornecedor </div>      <div class="param">armazemId (required)</div>
      
            <div class="param-desc"><span class="param-type">Path Parameter</span> &mdash; ID do armazem </div>    </div>  <!-- field-items -->

    <h3 class="field-label">Consumes</h3>
    This API call consumes the following media types via the <span class="header">Content-Type</span> request header:
    <ul>
      <li><code>application/json</code></li>
    </ul>

    <h3 class="field-label">Request body</h3>
    <div class="field-items">
      <div class="param">body <a href="#Produto">Produto</a> (optional)</div>
      
            <div class="param-desc"><span class="param-type">Body Parameter</span> &mdash;  </div>
                </div>  <!-- field-items -->





    <!--Todo: process Response Object and its headers, schema, examples -->



    <h3 class="field-label">Responses</h3>
    <h4 class="field-label">201</h4>
    Produto criado
        <a href="#"></a>
    <h4 class="field-label">400</h4>
    O servidor não consegue ou não irá processar o pedido devido a um erro por parte do cliente.
        <a href="#"></a>
  </div> <!-- method -->
  <hr/>
  <div class="method"><a name="deleteInventoryUniqueProduct"></a>
    <div class="method-path">
    <a class="up" href="#__Methods">Up</a>
    <pre class="delete"><code class="huge"><span class="http-method">delete</span> /fornecedores/{fornecedorId}/produto/{produtoId}</code></pre></div>
    <div class="method-summary">Apaga um produto (<span class="nickname">deleteInventoryUniqueProduct</span>)</div>
    <div class="method-notes">Apagar um produto de um fornecedor</div>

    <h3 class="field-label">Path parameters</h3>
    <div class="field-items">
      <div class="param">fornecedorId (required)</div>
      
            <div class="param-desc"><span class="param-type">Path Parameter</span> &mdash; ID do fornecedor </div>      <div class="param">produtoId (required)</div>
      
            <div class="param-desc"><span class="param-type">Path Parameter</span> &mdash; ID do produto </div>    </div>  <!-- field-items -->







    <!--Todo: process Response Object and its headers, schema, examples -->



    <h3 class="field-label">Responses</h3>
    <h4 class="field-label">200</h4>
    produto removido
        <a href="#"></a>
    <h4 class="field-label">400</h4>
    fornecedorId/produtoId inválido
        <a href="#"></a>
    <h4 class="field-label">401</h4>
    Utilizador não pode apagar o produto
        <a href="#"></a>
    <h4 class="field-label">404</h4>
    fornecedorId/produtoId não encontrado
        <a href="#"></a>
  </div> <!-- method -->
  <hr/>
  <div class="method"><a name="deleteOrder"></a>
    <div class="method-path">
    <a class="up" href="#__Methods">Up</a>
    <pre class="delete"><code class="huge"><span class="http-method">delete</span> /fornecedores/{fornecedorId}/encomendas/{encomendaId}</code></pre></div>
    <div class="method-summary"> (<span class="nickname">deleteOrder</span>)</div>
    <div class="method-notes">Apagar uma encomenda</div>

    <h3 class="field-label">Path parameters</h3>
    <div class="field-items">
      <div class="param">fornecedorId (required)</div>
      
            <div class="param-desc"><span class="param-type">Path Parameter</span> &mdash; ID do fornecedor </div>      <div class="param">encomendaId (required)</div>
      
            <div class="param-desc"><span class="param-type">Path Parameter</span> &mdash; ID do fornecedor </div>    </div>  <!-- field-items -->







    <!--Todo: process Response Object and its headers, schema, examples -->



    <h3 class="field-label">Responses</h3>
    <h4 class="field-label">200</h4>
    Encomenda apagada
        <a href="#"></a>
    <h4 class="field-label">400</h4>
    FornecedorId/encomendaId inválido
        <a href="#"></a>
    <h4 class="field-label">401</h4>
    Utilizador não pode apagar a encomenda
        <a href="#"></a>
    <h4 class="field-label">404</h4>
    FornecedorId/encomendaId não encontrado
        <a href="#"></a>
  </div> <!-- method -->
  <hr/>
  <div class="method"><a name="deleteProvider"></a>
    <div class="method-path">
    <a class="up" href="#__Methods">Up</a>
    <pre class="delete"><code class="huge"><span class="http-method">delete</span> /fornecedores/{fornecedorId}</code></pre></div>
    <div class="method-summary">Apaga um funcionario (<span class="nickname">deleteProvider</span>)</div>
    <div class="method-notes">Apaga um funcionario do sistema</div>

    <h3 class="field-label">Path parameters</h3>
    <div class="field-items">
      <div class="param">fornecedorId (required)</div>
      
            <div class="param-desc"><span class="param-type">Path Parameter</span> &mdash; ID do fornecedor </div>    </div>  <!-- field-items -->







    <!--Todo: process Response Object and its headers, schema, examples -->



    <h3 class="field-label">Responses</h3>
    <h4 class="field-label">200</h4>
    Fornecedor Apagado com Sucesso
        <a href="#"></a>
    <h4 class="field-label">400</h4>
    fornecedorId inválido
        <a href="#"></a>
    <h4 class="field-label">401</h4>
    Utilizador não pode apagar o fornecedor
        <a href="#"></a>
    <h4 class="field-label">404</h4>
    fornecedorId não encontrado
        <a href="#"></a>
  </div> <!-- method -->
  <hr/>
  <div class="method"><a name="deleteWarehouse"></a>
    <div class="method-path">
    <a class="up" href="#__Methods">Up</a>
    <pre class="delete"><code class="huge"><span class="http-method">delete</span> /fornecedores/{fornecedorId}/armazem/{armazemId}</code></pre></div>
    <div class="method-summary"> (<span class="nickname">deleteWarehouse</span>)</div>
    <div class="method-notes"></div>

    <h3 class="field-label">Path parameters</h3>
    <div class="field-items">
      <div class="param">fornecedorId (required)</div>
      
            <div class="param-desc"><span class="param-type">Path Parameter</span> &mdash; ID do fornecedor </div>      <div class="param">armazemId (required)</div>
      
            <div class="param-desc"><span class="param-type">Path Parameter</span> &mdash; ID do armazem </div>    </div>  <!-- field-items -->







    <!--Todo: process Response Object and its headers, schema, examples -->



    <h3 class="field-label">Responses</h3>
    <h4 class="field-label">200</h4>
    Armazem apagado
        <a href="#"></a>
    <h4 class="field-label">400</h4>
    FornecedorId/armazemId inválido
        <a href="#"></a>
    <h4 class="field-label">401</h4>
    Utilizador não pode apagar a encomenda
        <a href="#"></a>
    <h4 class="field-label">404</h4>
    FornecedorId/armazemId não encontrado
        <a href="#"></a>
  </div> <!-- method -->
  <hr/>
  <div class="method"><a name="getAllOrders"></a>
    <div class="method-path">
    <a class="up" href="#__Methods">Up</a>
    <pre class="get"><code class="huge"><span class="http-method">get</span> /fornecedores/{fornecedorId}/encomendas</code></pre></div>
    <div class="method-summary"> (<span class="nickname">getAllOrders</span>)</div>
    <div class="method-notes">Devolve as encomendas vindas de clientes que o fornecedor possui</div>

    <h3 class="field-label">Path parameters</h3>
    <div class="field-items">
      <div class="param">fornecedorId (required)</div>
      
            <div class="param-desc"><span class="param-type">Path Parameter</span> &mdash; ID do fornecedor format: int64</div>    </div>  <!-- field-items -->






    <h3 class="field-label">Return type</h3>
    <div class="return-type">
      array[<a href="#Encomenda">Encomenda</a>]
      
    </div>

    <!--Todo: process Response Object and its headers, schema, examples -->

    <h3 class="field-label">Example data</h3>
    <div class="example-data-content-type">Content-Type: application/json</div>
    <pre class="example"><code>[ {
  "Morada de Entrega" : "Morada de Entrega",
  "Preço" : 6,
  "Data Realizada" : "2000-01-23",
  "Produto ID" : 5,
  "EstadoDaEncomenda" : "confirmada",
  "Consumidor ID" : 5,
  "ID" : 0,
  "Data Finalizada" : "2000-01-23",
  "Transportadora ID" : 2,
  "Quantidade" : 1
}, {
  "Morada de Entrega" : "Morada de Entrega",
  "Preço" : 6,
  "Data Realizada" : "2000-01-23",
  "Produto ID" : 5,
  "EstadoDaEncomenda" : "confirmada",
  "Consumidor ID" : 5,
  "ID" : 0,
  "Data Finalizada" : "2000-01-23",
  "Transportadora ID" : 2,
  "Quantidade" : 1
} ]</code></pre>

    <h3 class="field-label">Produces</h3>
    This API call produces the following media types according to the <span class="header">Accept</span> request header;
    the media type will be conveyed by the <span class="header">Content-Type</span> response header.
    <ul>
      <li><code>application/json</code></li>
    </ul>

    <h3 class="field-label">Responses</h3>
    <h4 class="field-label">200</h4>
    successful operation
        
    <h4 class="field-label">400</h4>
    fornecedorId inválido
        <a href="#"></a>
    <h4 class="field-label">401</h4>
    Utilizador não pode visualizar as encomendas que o fornecedor possui
        <a href="#"></a>
    <h4 class="field-label">404</h4>
    fornecedorId não encontrado
        <a href="#"></a>
  </div> <!-- method -->
  <hr/>
  <div class="method"><a name="getAllProviders"></a>
    <div class="method-path">
    <a class="up" href="#__Methods">Up</a>
    <pre class="get"><code class="huge"><span class="http-method">get</span> /fornecedores</code></pre></div>
    <div class="method-summary">Lista dos fornecedores. (<span class="nickname">getAllProviders</span>)</div>
    <div class="method-notes">Devolve uma lista com todos os fornecedores.</div>







    <h3 class="field-label">Return type</h3>
    <div class="return-type">
      array[<a href="#Fornecedor">Fornecedor</a>]
      
    </div>

    <!--Todo: process Response Object and its headers, schema, examples -->

    <h3 class="field-label">Example data</h3>
    <div class="example-data-content-type">Content-Type: application/json</div>
    <pre class="example"><code>[ {
  "Email" : "Email",
  "Morada" : "Morada",
  "Telefone" : 111111111,
  "NIF" : 111111111,
  "ID" : 1,
  "Nome" : "Nome",
  "Password" : "Password"
}, {
  "Email" : "Email",
  "Morada" : "Morada",
  "Telefone" : 111111111,
  "NIF" : 111111111,
  "ID" : 1,
  "Nome" : "Nome",
  "Password" : "Password"
} ]</code></pre>

    <h3 class="field-label">Produces</h3>
    This API call produces the following media types according to the <span class="header">Accept</span> request header;
    the media type will be conveyed by the <span class="header">Content-Type</span> response header.
    <ul>
      <li><code>application/json</code></li>
    </ul>

    <h3 class="field-label">Responses</h3>
    <h4 class="field-label">200</h4>
    Operação bem-sucedida
        
    <h4 class="field-label">404</h4>
    Não foram encontrados fornecedors
        <a href="#"></a>
  </div> <!-- method -->
  <hr/>
  <div class="method"><a name="getAllWareHouses"></a>
    <div class="method-path">
    <a class="up" href="#__Methods">Up</a>
    <pre class="get"><code class="huge"><span class="http-method">get</span> /fornecedores/{fornecedorId}/armazem</code></pre></div>
    <div class="method-summary"> (<span class="nickname">getAllWareHouses</span>)</div>
    <div class="method-notes"></div>

    <h3 class="field-label">Path parameters</h3>
    <div class="field-items">
      <div class="param">fornecedorId (required)</div>
      
            <div class="param-desc"><span class="param-type">Path Parameter</span> &mdash; ID do fornecedor format: int64</div>    </div>  <!-- field-items -->






    <h3 class="field-label">Return type</h3>
    <div class="return-type">
      array[<a href="#Armazem">Armazem</a>]
      
    </div>

    <!--Todo: process Response Object and its headers, schema, examples -->

    <h3 class="field-label">Example data</h3>
    <div class="example-data-content-type">Content-Type: application/json</div>
    <pre class="example"><code>[ {
  "Morada" : "Morada",
  "Fornecedor ID" : 6,
  "ID" : 1
}, {
  "Morada" : "Morada",
  "Fornecedor ID" : 6,
  "ID" : 1
} ]</code></pre>

    <h3 class="field-label">Produces</h3>
    This API call produces the following media types according to the <span class="header">Accept</span> request header;
    the media type will be conveyed by the <span class="header">Content-Type</span> response header.
    <ul>
      <li><code>application/json</code></li>
    </ul>

    <h3 class="field-label">Responses</h3>
    <h4 class="field-label">200</h4>
    successful operation
        
    <h4 class="field-label">400</h4>
    fornecedorId inválido
        <a href="#"></a>
    <h4 class="field-label">401</h4>
    Utilizador não pode visualizar as encomendas que o fornecedor possui
        <a href="#"></a>
    <h4 class="field-label">404</h4>
    fornecedorId não encontrado
        <a href="#"></a>
  </div> <!-- method -->
  <hr/>
  <div class="method"><a name="getAllWarehouseProducts"></a>
    <div class="method-path">
    <a class="up" href="#__Methods">Up</a>
    <pre class="get"><code class="huge"><span class="http-method">get</span> /fornecedores/{fornecedorId}/armazem/{armazemId}/produto</code></pre></div>
    <div class="method-summary">Lista dos produtos do armazem. (<span class="nickname">getAllWarehouseProducts</span>)</div>
    <div class="method-notes"></div>

    <h3 class="field-label">Path parameters</h3>
    <div class="field-items">
      <div class="param">fornecedorId (required)</div>
      
            <div class="param-desc"><span class="param-type">Path Parameter</span> &mdash; ID do fornecedor </div>      <div class="param">armazemId (required)</div>
      
            <div class="param-desc"><span class="param-type">Path Parameter</span> &mdash; ID do armazem </div>    </div>  <!-- field-items -->






    <h3 class="field-label">Return type</h3>
    <div class="return-type">
      array[<a href="#Produto">Produto</a>]
      
    </div>

    <!--Todo: process Response Object and its headers, schema, examples -->

    <h3 class="field-label">Example data</h3>
    <div class="example-data-content-type">Content-Type: application/json</div>
    <pre class="example"><code>[ {
  "Armazem ID" : 1,
  "Preco" : 6,
  "Subcategoria" : "Subcategoria",
  "Data de Produção do Produto" : "2000-01-23",
  "Categoria" : "Categoria",
  "Date de inserção no site" : "2000-01-23",
  "Informação Arbitrária" : "Informação Arbitrária",
  "Fornecedor ID" : 5,
  "ID" : 0,
  "Nome" : "Nome",
  "Poluição gerada por dia" : "Poluição gerada por dia"
}, {
  "Armazem ID" : 1,
  "Preco" : 6,
  "Subcategoria" : "Subcategoria",
  "Data de Produção do Produto" : "2000-01-23",
  "Categoria" : "Categoria",
  "Date de inserção no site" : "2000-01-23",
  "Informação Arbitrária" : "Informação Arbitrária",
  "Fornecedor ID" : 5,
  "ID" : 0,
  "Nome" : "Nome",
  "Poluição gerada por dia" : "Poluição gerada por dia"
} ]</code></pre>

    <h3 class="field-label">Produces</h3>
    This API call produces the following media types according to the <span class="header">Accept</span> request header;
    the media type will be conveyed by the <span class="header">Content-Type</span> response header.
    <ul>
      <li><code>application/json</code></li>
    </ul>

    <h3 class="field-label">Responses</h3>
    <h4 class="field-label">200</h4>
    successful operation
        
    <h4 class="field-label">404</h4>
    Não foram encontrados produtos no armazem
        <a href="#"></a>
  </div> <!-- method -->
  <hr/>
  <div class="method"><a name="getInventory"></a>
    <div class="method-path">
    <a class="up" href="#__Methods">Up</a>
    <pre class="get"><code class="huge"><span class="http-method">get</span> /fornecedores/{fornecedorId}/produto</code></pre></div>
    <div class="method-summary"> (<span class="nickname">getInventory</span>)</div>
    <div class="method-notes">Devolve todos os produtos para venda do fornecedor</div>

    <h3 class="field-label">Path parameters</h3>
    <div class="field-items">
      <div class="param">fornecedorId (required)</div>
      
            <div class="param-desc"><span class="param-type">Path Parameter</span> &mdash; ID do fornecedor </div>    </div>  <!-- field-items -->






    <h3 class="field-label">Return type</h3>
    <div class="return-type">
      <a href="#Produto">Produto</a>
      
    </div>

    <!--Todo: process Response Object and its headers, schema, examples -->

    <h3 class="field-label">Example data</h3>
    <div class="example-data-content-type">Content-Type: application/json</div>
    <pre class="example"><code>{
  "Armazem ID" : 1,
  "Preco" : 6,
  "Subcategoria" : "Subcategoria",
  "Data de Produção do Produto" : "2000-01-23",
  "Categoria" : "Categoria",
  "Date de inserção no site" : "2000-01-23",
  "Informação Arbitrária" : "Informação Arbitrária",
  "Fornecedor ID" : 5,
  "ID" : 0,
  "Nome" : "Nome",
  "Poluição gerada por dia" : "Poluição gerada por dia"
}</code></pre>

    <h3 class="field-label">Produces</h3>
    This API call produces the following media types according to the <span class="header">Accept</span> request header;
    the media type will be conveyed by the <span class="header">Content-Type</span> response header.
    <ul>
      <li><code>application/json</code></li>
    </ul>

    <h3 class="field-label">Responses</h3>
    <h4 class="field-label">200</h4>
    successful operation
        <a href="#Produto">Produto</a>
    <h4 class="field-label">400</h4>
    fornecedorId inválido
        <a href="#"></a>
    <h4 class="field-label">404</h4>
    fornecedorId não encontrado
        <a href="#"></a>
  </div> <!-- method -->
  <hr/>
  <div class="method"><a name="getInventoryUniqueProduct"></a>
    <div class="method-path">
    <a class="up" href="#__Methods">Up</a>
    <pre class="get"><code class="huge"><span class="http-method">get</span> /fornecedores/{fornecedorId}/produto/{produtoId}</code></pre></div>
    <div class="method-summary"> (<span class="nickname">getInventoryUniqueProduct</span>)</div>
    <div class="method-notes">Devolve um produto do inventario de produtos para venda do fornecedor</div>

    <h3 class="field-label">Path parameters</h3>
    <div class="field-items">
      <div class="param">fornecedorId (required)</div>
      
            <div class="param-desc"><span class="param-type">Path Parameter</span> &mdash; ID do fornecedor </div>      <div class="param">produtoId (required)</div>
      
            <div class="param-desc"><span class="param-type">Path Parameter</span> &mdash; ID do produto </div>    </div>  <!-- field-items -->






    <h3 class="field-label">Return type</h3>
    <div class="return-type">
      <a href="#Produto">Produto</a>
      
    </div>

    <!--Todo: process Response Object and its headers, schema, examples -->

    <h3 class="field-label">Example data</h3>
    <div class="example-data-content-type">Content-Type: application/json</div>
    <pre class="example"><code>{
  "Armazem ID" : 1,
  "Preco" : 6,
  "Subcategoria" : "Subcategoria",
  "Data de Produção do Produto" : "2000-01-23",
  "Categoria" : "Categoria",
  "Date de inserção no site" : "2000-01-23",
  "Informação Arbitrária" : "Informação Arbitrária",
  "Fornecedor ID" : 5,
  "ID" : 0,
  "Nome" : "Nome",
  "Poluição gerada por dia" : "Poluição gerada por dia"
}</code></pre>

    <h3 class="field-label">Produces</h3>
    This API call produces the following media types according to the <span class="header">Accept</span> request header;
    the media type will be conveyed by the <span class="header">Content-Type</span> response header.
    <ul>
      <li><code>application/json</code></li>
    </ul>

    <h3 class="field-label">Responses</h3>
    <h4 class="field-label">200</h4>
    successful operation
        <a href="#Produto">Produto</a>
    <h4 class="field-label">400</h4>
    fornecedorId/produtoId inválido
        <a href="#"></a>
    <h4 class="field-label">401</h4>
    Utilizador não pode visualizar o inventario
        <a href="#"></a>
    <h4 class="field-label">404</h4>
    fornecedorId/produtoId não encontrado
        <a href="#"></a>
  </div> <!-- method -->
  <hr/>
  <div class="method"><a name="getUniqueOrder"></a>
    <div class="method-path">
    <a class="up" href="#__Methods">Up</a>
    <pre class="get"><code class="huge"><span class="http-method">get</span> /fornecedores/{fornecedorId}/encomendas/{encomendaId}</code></pre></div>
    <div class="method-summary"> (<span class="nickname">getUniqueOrder</span>)</div>
    <div class="method-notes">Devolve uma encomenda vinda de um cliente que o fornecedor possui</div>

    <h3 class="field-label">Path parameters</h3>
    <div class="field-items">
      <div class="param">fornecedorId (required)</div>
      
            <div class="param-desc"><span class="param-type">Path Parameter</span> &mdash; ID do fornecedor </div>      <div class="param">encomendaId (required)</div>
      
            <div class="param-desc"><span class="param-type">Path Parameter</span> &mdash; ID do fornecedor </div>    </div>  <!-- field-items -->






    <h3 class="field-label">Return type</h3>
    <div class="return-type">
      <a href="#Encomenda">Encomenda</a>
      
    </div>

    <!--Todo: process Response Object and its headers, schema, examples -->

    <h3 class="field-label">Example data</h3>
    <div class="example-data-content-type">Content-Type: application/json</div>
    <pre class="example"><code>{
  "Morada de Entrega" : "Morada de Entrega",
  "Preço" : 6,
  "Data Realizada" : "2000-01-23",
  "Produto ID" : 5,
  "EstadoDaEncomenda" : "confirmada",
  "Consumidor ID" : 5,
  "ID" : 0,
  "Data Finalizada" : "2000-01-23",
  "Transportadora ID" : 2,
  "Quantidade" : 1
}</code></pre>

    <h3 class="field-label">Produces</h3>
    This API call produces the following media types according to the <span class="header">Accept</span> request header;
    the media type will be conveyed by the <span class="header">Content-Type</span> response header.
    <ul>
      <li><code>application/json</code></li>
    </ul>

    <h3 class="field-label">Responses</h3>
    <h4 class="field-label">200</h4>
    successful operation
        <a href="#Encomenda">Encomenda</a>
    <h4 class="field-label">400</h4>
    fornecedorId/encomendaId inválido
        <a href="#"></a>
    <h4 class="field-label">401</h4>
    Utilizador não pode visualizar a encomenda
        <a href="#"></a>
    <h4 class="field-label">404</h4>
    fornecedorId/encomendaId não encontrado
        <a href="#"></a>
  </div> <!-- method -->
  <hr/>
  <div class="method"><a name="getUniqueProvider"></a>
    <div class="method-path">
    <a class="up" href="#__Methods">Up</a>
    <pre class="get"><code class="huge"><span class="http-method">get</span> /fornecedores/{fornecedorId}</code></pre></div>
    <div class="method-summary">Encontra um fornecedor pelo ID (<span class="nickname">getUniqueProvider</span>)</div>
    <div class="method-notes">Devolve parte das informações de um fornecedor</div>

    <h3 class="field-label">Path parameters</h3>
    <div class="field-items">
      <div class="param">fornecedorId (required)</div>
      
            <div class="param-desc"><span class="param-type">Path Parameter</span> &mdash; ID do fornecedor a devolver format: int64</div>    </div>  <!-- field-items -->






    <h3 class="field-label">Return type</h3>
    <div class="return-type">
      <a href="#Fornecedor">Fornecedor</a>
      
    </div>

    <!--Todo: process Response Object and its headers, schema, examples -->

    <h3 class="field-label">Example data</h3>
    <div class="example-data-content-type">Content-Type: application/json</div>
    <pre class="example"><code>{
  "Email" : "Email",
  "Morada" : "Morada",
  "Telefone" : 111111111,
  "NIF" : 111111111,
  "ID" : 1,
  "Nome" : "Nome",
  "Password" : "Password"
}</code></pre>

    <h3 class="field-label">Produces</h3>
    This API call produces the following media types according to the <span class="header">Accept</span> request header;
    the media type will be conveyed by the <span class="header">Content-Type</span> response header.
    <ul>
      <li><code>application/json</code></li>
    </ul>

    <h3 class="field-label">Responses</h3>
    <h4 class="field-label">200</h4>
    Operação bem-sucedida
        <a href="#Fornecedor">Fornecedor</a>
    <h4 class="field-label">400</h4>
    FornecedorId inválido
        <a href="#"></a>
    <h4 class="field-label">404</h4>
    FornecedorId não encontrado
        <a href="#"></a>
  </div> <!-- method -->
  <hr/>
  <div class="method"><a name="getUniqueWarehouse"></a>
    <div class="method-path">
    <a class="up" href="#__Methods">Up</a>
    <pre class="get"><code class="huge"><span class="http-method">get</span> /fornecedores/{fornecedorId}/armazem/{armazemId}</code></pre></div>
    <div class="method-summary"> (<span class="nickname">getUniqueWarehouse</span>)</div>
    <div class="method-notes"></div>

    <h3 class="field-label">Path parameters</h3>
    <div class="field-items">
      <div class="param">fornecedorId (required)</div>
      
            <div class="param-desc"><span class="param-type">Path Parameter</span> &mdash; ID do fornecedor </div>      <div class="param">armazemId (required)</div>
      
            <div class="param-desc"><span class="param-type">Path Parameter</span> &mdash; ID do fornecedor </div>    </div>  <!-- field-items -->






    <h3 class="field-label">Return type</h3>
    <div class="return-type">
      <a href="#Armazem">Armazem</a>
      
    </div>

    <!--Todo: process Response Object and its headers, schema, examples -->

    <h3 class="field-label">Example data</h3>
    <div class="example-data-content-type">Content-Type: application/json</div>
    <pre class="example"><code>{
  "Morada" : "Morada",
  "Fornecedor ID" : 6,
  "ID" : 1
}</code></pre>

    <h3 class="field-label">Produces</h3>
    This API call produces the following media types according to the <span class="header">Accept</span> request header;
    the media type will be conveyed by the <span class="header">Content-Type</span> response header.
    <ul>
      <li><code>application/json</code></li>
    </ul>

    <h3 class="field-label">Responses</h3>
    <h4 class="field-label">200</h4>
    successful operation
        <a href="#Armazem">Armazem</a>
    <h4 class="field-label">400</h4>
    fornecedorId/armazemId inválido
        <a href="#"></a>
    <h4 class="field-label">401</h4>
    Utilizador não pode visualizar a encomenda
        <a href="#"></a>
    <h4 class="field-label">404</h4>
    fornecedorId/armazemId não encontrado
        <a href="#"></a>
  </div> <!-- method -->
  <hr/>
  <div class="method"><a name="updateProductInInventory"></a>
    <div class="method-path">
    <a class="up" href="#__Methods">Up</a>
    <pre class="put"><code class="huge"><span class="http-method">put</span> /fornecedores/{fornecedorId}/produto/{produtoId}</code></pre></div>
    <div class="method-summary">Produto do fornecedor atualizado (<span class="nickname">updateProductInInventory</span>)</div>
    <div class="method-notes">Atualizar todas as informações de um produto na lista de produtos de um fornecedor</div>

    <h3 class="field-label">Path parameters</h3>
    <div class="field-items">
      <div class="param">fornecedorId (required)</div>
      
            <div class="param-desc"><span class="param-type">Path Parameter</span> &mdash; ID do fornecedor </div>      <div class="param">produtoId (required)</div>
      
            <div class="param-desc"><span class="param-type">Path Parameter</span> &mdash; ID do produto </div>    </div>  <!-- field-items -->

    <h3 class="field-label">Consumes</h3>
    This API call consumes the following media types via the <span class="header">Content-Type</span> request header:
    <ul>
      <li><code>application/json</code></li>
    </ul>

    <h3 class="field-label">Request body</h3>
    <div class="field-items">
      <div class="param">body <a href="#Produto">Produto</a> (required)</div>
      
            <div class="param-desc"><span class="param-type">Body Parameter</span> &mdash; Objeto JSON que contém a informação do produto </div>
                </div>  <!-- field-items -->





    <!--Todo: process Response Object and its headers, schema, examples -->



    <h3 class="field-label">Responses</h3>
    <h4 class="field-label">200</h4>
    produto atualizado
        <a href="#"></a>
    <h4 class="field-label">400</h4>
    fornecedorId/produtoId inválido
        <a href="#"></a>
    <h4 class="field-label">401</h4>
    Utilizador não pode criar o produto
        <a href="#"></a>
    <h4 class="field-label">404</h4>
    fornecedorId/produtoId não encontrado
        <a href="#"></a>
  </div> <!-- method -->
  <hr/>
  <div class="method"><a name="updateProviderInfos"></a>
    <div class="method-path">
    <a class="up" href="#__Methods">Up</a>
    <pre class="put"><code class="huge"><span class="http-method">put</span> /fornecedores/{fornecedorId}</code></pre></div>
    <div class="method-summary">Fornecedor Atualizado (<span class="nickname">updateProviderInfos</span>)</div>
    <div class="method-notes">Atualiza as informações de um fornecedor</div>

    <h3 class="field-label">Path parameters</h3>
    <div class="field-items">
      <div class="param">fornecedorId (required)</div>
      
            <div class="param-desc"><span class="param-type">Path Parameter</span> &mdash; ID do fornecedor </div>    </div>  <!-- field-items -->

    <h3 class="field-label">Consumes</h3>
    This API call consumes the following media types via the <span class="header">Content-Type</span> request header:
    <ul>
      <li><code>application/json</code></li>
    </ul>

    <h3 class="field-label">Request body</h3>
    <div class="field-items">
      <div class="param">body <a href="#Fornecedor">Fornecedor</a> (required)</div>
      
            <div class="param-desc"><span class="param-type">Body Parameter</span> &mdash; Objeto JSON que contém a informação do fornecedor </div>
                </div>  <!-- field-items -->





    <!--Todo: process Response Object and its headers, schema, examples -->



    <h3 class="field-label">Responses</h3>
    <h4 class="field-label">400</h4>
    fornecedorId inválido
        <a href="#"></a>
    <h4 class="field-label">401</h4>
    Utilizador não pode atualizar o fornecedor
        <a href="#"></a>
    <h4 class="field-label">404</h4>
    fornecedorId não encontrado
        <a href="#"></a>
  </div> <!-- method -->
  <hr/>
  <div class="method"><a name="updateWarehouse"></a>
    <div class="method-path">
    <a class="up" href="#__Methods">Up</a>
    <pre class="put"><code class="huge"><span class="http-method">put</span> /fornecedores/{fornecedorId}/armazem/{armazemId}</code></pre></div>
    <div class="method-summary">Armazem Atualizado (<span class="nickname">updateWarehouse</span>)</div>
    <div class="method-notes"></div>

    <h3 class="field-label">Path parameters</h3>
    <div class="field-items">
      <div class="param">fornecedorId (required)</div>
      
            <div class="param-desc"><span class="param-type">Path Parameter</span> &mdash;  </div>      <div class="param">armazemId (required)</div>
      
            <div class="param-desc"><span class="param-type">Path Parameter</span> &mdash; ID do Armazem format: int64</div>    </div>  <!-- field-items -->

    <h3 class="field-label">Consumes</h3>
    This API call consumes the following media types via the <span class="header">Content-Type</span> request header:
    <ul>
      <li><code>application/json</code></li>
    </ul>

    <h3 class="field-label">Request body</h3>
    <div class="field-items">
      <div class="param">body <a href="#Armazem">Armazem</a> (required)</div>
      
            <div class="param-desc"><span class="param-type">Body Parameter</span> &mdash; Objeto JSON que contém a informação do armazem </div>
                </div>  <!-- field-items -->





    <!--Todo: process Response Object and its headers, schema, examples -->



    <h3 class="field-label">Responses</h3>
    <h4 class="field-label">400</h4>
    fornecedorId/armazemID inválido
        <a href="#"></a>
    <h4 class="field-label">401</h4>
    Utilizador não pode atualizar a base
        <a href="#"></a>
    <h4 class="field-label">404</h4>
    fornecedorId/armazemID não encontrado
        <a href="#"></a>
  </div> <!-- method -->
  <hr/>
  <h1><a name="Transportadora">Transportadora</a></h1>
  <div class="method"><a name="createShippingBase"></a>
    <div class="method-path">
    <a class="up" href="#__Methods">Up</a>
    <pre class="post"><code class="huge"><span class="http-method">post</span> /transportadoras/{transportadoraId}/bases</code></pre></div>
    <div class="method-summary">Adiciona uma nova base à transportadora (<span class="nickname">createShippingBase</span>)</div>
    <div class="method-notes"></div>

    <h3 class="field-label">Path parameters</h3>
    <div class="field-items">
      <div class="param">transportadoraId (required)</div>
      
            <div class="param-desc"><span class="param-type">Path Parameter</span> &mdash; A base da qual se quer informações. format: int64</div>    </div>  <!-- field-items -->

    <h3 class="field-label">Consumes</h3>
    This API call consumes the following media types via the <span class="header">Content-Type</span> request header:
    <ul>
      <li><code>application/json</code></li>
    </ul>

    <h3 class="field-label">Request body</h3>
    <div class="field-items">
      <div class="param">body <a href="#Base">Base</a> (optional)</div>
      
            <div class="param-desc"><span class="param-type">Body Parameter</span> &mdash;  </div>
                </div>  <!-- field-items -->





    <!--Todo: process Response Object and its headers, schema, examples -->



    <h3 class="field-label">Responses</h3>
    <h4 class="field-label">201</h4>
    Base criada
        <a href="#"></a>
    <h4 class="field-label">400</h4>
    O servidor não consegue ou não irá processar o pedido devido a um erro por parte do cliente.
        <a href="#"></a>
  </div> <!-- method -->
  <hr/>
  <div class="method"><a name="createTransporter"></a>
    <div class="method-path">
    <a class="up" href="#__Methods">Up</a>
    <pre class="post"><code class="huge"><span class="http-method">post</span> /transportadoras</code></pre></div>
    <div class="method-summary">Adiciona uma nova transportadora (<span class="nickname">createTransporter</span>)</div>
    <div class="method-notes"></div>


    <h3 class="field-label">Consumes</h3>
    This API call consumes the following media types via the <span class="header">Content-Type</span> request header:
    <ul>
      <li><code>application/json</code></li>
    </ul>

    <h3 class="field-label">Request body</h3>
    <div class="field-items">
      <div class="param">body <a href="#Transportadora">Transportadora</a> (optional)</div>
      
            <div class="param-desc"><span class="param-type">Body Parameter</span> &mdash;  </div>
            <div class="param-desc"><span class="param-type">example: <code>{
  &quot;nome&quot; : &quot;Transportes&quot;,
  &quot;email&quot; : &quot;Transportes@gmail.com&quot;,
  &quot;password&quot; : &quot;Transportes&quot;,
  &quot;morada&quot; : &quot;Rua de Cabo Verde 5, Amadora&quot;,
  &quot;nif&quot; : 123456789,
  &quot;telefone&quot; : 987654321
}</code></span></div>    </div>  <!-- field-items -->





    <!--Todo: process Response Object and its headers, schema, examples -->



    <h3 class="field-label">Responses</h3>
    <h4 class="field-label">201</h4>
    Transportadora criada
        <a href="#"></a>
    <h4 class="field-label">400</h4>
    O servidor não consegue ou não irá processar o pedido devido a um erro por parte do cliente.
        <a href="#"></a>
  </div> <!-- method -->
  <hr/>
  <div class="method"><a name="deleteShippingBase"></a>
    <div class="method-path">
    <a class="up" href="#__Methods">Up</a>
    <pre class="delete"><code class="huge"><span class="http-method">delete</span> /transportadoras/{transportadoraId}/bases/{baseID}</code></pre></div>
    <div class="method-summary">Apagar uma base (<span class="nickname">deleteShippingBase</span>)</div>
    <div class="method-notes">Esta operação só pode ser realizada por um utilizador autenticado</div>

    <h3 class="field-label">Path parameters</h3>
    <div class="field-items">
      <div class="param">transportadoraId (required)</div>
      
            <div class="param-desc"><span class="param-type">Path Parameter</span> &mdash; O ID da transportadora </div>      <div class="param">baseID (required)</div>
      
            <div class="param-desc"><span class="param-type">Path Parameter</span> &mdash; ID da base format: int64</div>    </div>  <!-- field-items -->







    <!--Todo: process Response Object and its headers, schema, examples -->



    <h3 class="field-label">Responses</h3>
    <h4 class="field-label">400</h4>
    transportadoraId/baseID inválido
        <a href="#"></a>
    <h4 class="field-label">401</h4>
    Utilizador não pode apagar a transportadora
        <a href="#"></a>
    <h4 class="field-label">404</h4>
    transportadoraId/baseID não encontrado
        <a href="#"></a>
  </div> <!-- method -->
  <hr/>
  <div class="method"><a name="deleteShippingCompany"></a>
    <div class="method-path">
    <a class="up" href="#__Methods">Up</a>
    <pre class="delete"><code class="huge"><span class="http-method">delete</span> /transportadoras/{transportadoraId}</code></pre></div>
    <div class="method-summary">Apagar a conta de uma transportadora (<span class="nickname">deleteShippingCompany</span>)</div>
    <div class="method-notes">Esta operação só pode ser realizada por um utilizador autenticado</div>

    <h3 class="field-label">Path parameters</h3>
    <div class="field-items">
      <div class="param">transportadoraId (required)</div>
      
            <div class="param-desc"><span class="param-type">Path Parameter</span> &mdash; O ID da conta da transportadora que vai ser apagada </div>    </div>  <!-- field-items -->







    <!--Todo: process Response Object and its headers, schema, examples -->



    <h3 class="field-label">Responses</h3>
    <h4 class="field-label">400</h4>
    transportadoraId inválido
        <a href="#"></a>
    <h4 class="field-label">401</h4>
    Utilizador não pode apagar a transportadora
        <a href="#"></a>
    <h4 class="field-label">404</h4>
    transportadoraId não encontrado
        <a href="#"></a>
  </div> <!-- method -->
  <hr/>
  <div class="method"><a name="getAllShippingCompany"></a>
    <div class="method-path">
    <a class="up" href="#__Methods">Up</a>
    <pre class="get"><code class="huge"><span class="http-method">get</span> /transportadoras</code></pre></div>
    <div class="method-summary">Lista das transportadoras. (<span class="nickname">getAllShippingCompany</span>)</div>
    <div class="method-notes">Devolve uma lista com todas as transportadoras.</div>







    <h3 class="field-label">Return type</h3>
    <div class="return-type">
      array[<a href="#Transportadora">Transportadora</a>]
      
    </div>

    <!--Todo: process Response Object and its headers, schema, examples -->

    <h3 class="field-label">Example data</h3>
    <div class="example-data-content-type">Content-Type: application/json</div>
    <pre class="example"><code>[ {
  "Email" : "Email",
  "Morada" : "Morada",
  "Telefone" : 111111111,
  "NIF" : 111111111,
  "ID" : 1,
  "Nome" : "Nome",
  "Password" : "Password"
}, {
  "Email" : "Email",
  "Morada" : "Morada",
  "Telefone" : 111111111,
  "NIF" : 111111111,
  "ID" : 1,
  "Nome" : "Nome",
  "Password" : "Password"
} ]</code></pre>

    <h3 class="field-label">Produces</h3>
    This API call produces the following media types according to the <span class="header">Accept</span> request header;
    the media type will be conveyed by the <span class="header">Content-Type</span> response header.
    <ul>
      <li><code>application/json</code></li>
    </ul>

    <h3 class="field-label">Responses</h3>
    <h4 class="field-label">200</h4>
    successful operation
        
    <h4 class="field-label">404</h4>
    Não foram encontrados transportadoras
        <a href="#"></a>
  </div> <!-- method -->
  <hr/>
  <div class="method"><a name="getShippingBase"></a>
    <div class="method-path">
    <a class="up" href="#__Methods">Up</a>
    <pre class="get"><code class="huge"><span class="http-method">get</span> /transportadoras/{transportadoraId}/bases/{baseID}</code></pre></div>
    <div class="method-summary">Encontra a base (<span class="nickname">getShippingBase</span>)</div>
    <div class="method-notes">Devolve todas as informações da base da transportadora</div>

    <h3 class="field-label">Path parameters</h3>
    <div class="field-items">
      <div class="param">transportadoraId (required)</div>
      
            <div class="param-desc"><span class="param-type">Path Parameter</span> &mdash; ID da transportadora format: int64</div>      <div class="param">baseID (required)</div>
      
            <div class="param-desc"><span class="param-type">Path Parameter</span> &mdash; ID da base format: int64</div>    </div>  <!-- field-items -->






    <h3 class="field-label">Return type</h3>
    <div class="return-type">
      <a href="#Base">Base</a>
      
    </div>

    <!--Todo: process Response Object and its headers, schema, examples -->

    <h3 class="field-label">Example data</h3>
    <div class="example-data-content-type">Content-Type: application/json</div>
    <pre class="example"><code>{
  "Morada" : "Morada",
  "Telefone" : 1,
  "ID" : 1,
  "Transportadora ID" : 6
}</code></pre>

    <h3 class="field-label">Produces</h3>
    This API call produces the following media types according to the <span class="header">Accept</span> request header;
    the media type will be conveyed by the <span class="header">Content-Type</span> response header.
    <ul>
      <li><code>application/json</code></li>
    </ul>

    <h3 class="field-label">Responses</h3>
    <h4 class="field-label">200</h4>
    successful operation
        <a href="#Base">Base</a>
    <h4 class="field-label">400</h4>
    transportadoraId/baseID inválido
        <a href="#"></a>
    <h4 class="field-label">401</h4>
    Utilizador não pode visualizar informações sobre a base da transportadora
        <a href="#"></a>
    <h4 class="field-label">404</h4>
    Transportadora/base não encontrados
        <a href="#"></a>
  </div> <!-- method -->
  <hr/>
  <div class="method"><a name="getShippingBases"></a>
    <div class="method-path">
    <a class="up" href="#__Methods">Up</a>
    <pre class="get"><code class="huge"><span class="http-method">get</span> /transportadoras/{transportadoraId}/bases</code></pre></div>
    <div class="method-summary">Encontra a base de uma transportadora (<span class="nickname">getShippingBases</span>)</div>
    <div class="method-notes">Devolve todas as informações da base</div>

    <h3 class="field-label">Path parameters</h3>
    <div class="field-items">
      <div class="param">transportadoraId (required)</div>
      
            <div class="param-desc"><span class="param-type">Path Parameter</span> &mdash; A base da qual se quer informações. format: int64</div>    </div>  <!-- field-items -->






    <h3 class="field-label">Return type</h3>
    <div class="return-type">
      <a href="#Base">Base</a>
      
    </div>

    <!--Todo: process Response Object and its headers, schema, examples -->

    <h3 class="field-label">Example data</h3>
    <div class="example-data-content-type">Content-Type: application/json</div>
    <pre class="example"><code>{
  "Morada" : "Morada",
  "Telefone" : 1,
  "ID" : 1,
  "Transportadora ID" : 6
}</code></pre>

    <h3 class="field-label">Produces</h3>
    This API call produces the following media types according to the <span class="header">Accept</span> request header;
    the media type will be conveyed by the <span class="header">Content-Type</span> response header.
    <ul>
      <li><code>application/json</code></li>
    </ul>

    <h3 class="field-label">Responses</h3>
    <h4 class="field-label">200</h4>
    successful operation
        <a href="#Base">Base</a>
    <h4 class="field-label">400</h4>
    transportadoraId inválido
        <a href="#"></a>
    <h4 class="field-label">401</h4>
    Utilizador não pode visualizar informações sobre as bases da transportadora
        <a href="#"></a>
    <h4 class="field-label">404</h4>
    Bases não encontradas
        <a href="#"></a>
  </div> <!-- method -->
  <hr/>
  <div class="method"><a name="getUniqueShippingCompany"></a>
    <div class="method-path">
    <a class="up" href="#__Methods">Up</a>
    <pre class="get"><code class="huge"><span class="http-method">get</span> /transportadoras/{transportadoraId}</code></pre></div>
    <div class="method-summary">Encontra a transportadora (<span class="nickname">getUniqueShippingCompany</span>)</div>
    <div class="method-notes">Devolve todas as informações da transportadora</div>

    <h3 class="field-label">Path parameters</h3>
    <div class="field-items">
      <div class="param">transportadoraId (required)</div>
      
            <div class="param-desc"><span class="param-type">Path Parameter</span> &mdash; A transportadora da qual se quer informações. format: int64</div>    </div>  <!-- field-items -->






    <h3 class="field-label">Return type</h3>
    <div class="return-type">
      <a href="#Transportadora">Transportadora</a>
      
    </div>

    <!--Todo: process Response Object and its headers, schema, examples -->

    <h3 class="field-label">Example data</h3>
    <div class="example-data-content-type">Content-Type: application/json</div>
    <pre class="example"><code>{
  "Email" : "Email",
  "Morada" : "Morada",
  "Telefone" : 111111111,
  "NIF" : 111111111,
  "ID" : 1,
  "Nome" : "Nome",
  "Password" : "Password"
}</code></pre>

    <h3 class="field-label">Produces</h3>
    This API call produces the following media types according to the <span class="header">Accept</span> request header;
    the media type will be conveyed by the <span class="header">Content-Type</span> response header.
    <ul>
      <li><code>application/json</code></li>
    </ul>

    <h3 class="field-label">Responses</h3>
    <h4 class="field-label">200</h4>
    successful operation
        <a href="#Transportadora">Transportadora</a>
    <h4 class="field-label">400</h4>
    transportadoraId inválido
        <a href="#"></a>
    <h4 class="field-label">401</h4>
    Utilizador não pode visualizar informações sobre a transportadora
        <a href="#"></a>
    <h4 class="field-label">404</h4>
    Transportadora não encontrado
        <a href="#"></a>
  </div> <!-- method -->
  <hr/>
  <div class="method"><a name="updateShippingBase"></a>
    <div class="method-path">
    <a class="up" href="#__Methods">Up</a>
    <pre class="put"><code class="huge"><span class="http-method">put</span> /transportadoras/{transportadoraId}/bases/{baseID}</code></pre></div>
    <div class="method-summary">Base Atualizada (<span class="nickname">updateShippingBase</span>)</div>
    <div class="method-notes">Atualizar todas as informações de uma base. Esta operação só pode ser realizada por um utilizador autenticado</div>

    <h3 class="field-label">Path parameters</h3>
    <div class="field-items">
      <div class="param">transportadoraId (required)</div>
      
            <div class="param-desc"><span class="param-type">Path Parameter</span> &mdash; ID da transportadora </div>      <div class="param">baseID (required)</div>
      
            <div class="param-desc"><span class="param-type">Path Parameter</span> &mdash; ID da base format: int64</div>    </div>  <!-- field-items -->

    <h3 class="field-label">Consumes</h3>
    This API call consumes the following media types via the <span class="header">Content-Type</span> request header:
    <ul>
      <li><code>application/json</code></li>
    </ul>

    <h3 class="field-label">Request body</h3>
    <div class="field-items">
      <div class="param">body <a href="#Base">Base</a> (required)</div>
      
            <div class="param-desc"><span class="param-type">Body Parameter</span> &mdash; Objeto JSON que contém a informação da base </div>
                </div>  <!-- field-items -->





    <!--Todo: process Response Object and its headers, schema, examples -->



    <h3 class="field-label">Responses</h3>
    <h4 class="field-label">400</h4>
    transportadoraId/baseID inválido
        <a href="#"></a>
    <h4 class="field-label">401</h4>
    Utilizador não pode atualizar a base
        <a href="#"></a>
    <h4 class="field-label">404</h4>
    transportadoraId/baseID não encontrado
        <a href="#"></a>
  </div> <!-- method -->
  <hr/>
  <div class="method"><a name="updateShippingCompany"></a>
    <div class="method-path">
    <a class="up" href="#__Methods">Up</a>
    <pre class="put"><code class="huge"><span class="http-method">put</span> /transportadoras/{transportadoraId}</code></pre></div>
    <div class="method-summary">Transportadora Atualizada (<span class="nickname">updateShippingCompany</span>)</div>
    <div class="method-notes">Atualizar todas as informações de uma transportadora. Esta operação só pode ser realizada por um utilizador autenticado</div>

    <h3 class="field-label">Path parameters</h3>
    <div class="field-items">
      <div class="param">transportadoraId (required)</div>
      
            <div class="param-desc"><span class="param-type">Path Parameter</span> &mdash; ID da transportadora a ser atualizada </div>    </div>  <!-- field-items -->

    <h3 class="field-label">Consumes</h3>
    This API call consumes the following media types via the <span class="header">Content-Type</span> request header:
    <ul>
      <li><code>application/json</code></li>
    </ul>

    <h3 class="field-label">Request body</h3>
    <div class="field-items">
      <div class="param">body <a href="#Transportadora">Transportadora</a> (required)</div>
      
            <div class="param-desc"><span class="param-type">Body Parameter</span> &mdash; Objeto JSON que contém a informação da transportadora </div>
                </div>  <!-- field-items -->





    <!--Todo: process Response Object and its headers, schema, examples -->



    <h3 class="field-label">Responses</h3>
    <h4 class="field-label">400</h4>
    transportadoraId inválido
        <a href="#"></a>
    <h4 class="field-label">401</h4>
    Utilizador não pode atualizar a transportadora
        <a href="#"></a>
    <h4 class="field-label">404</h4>
    transportadoraId não encontrado
        <a href="#"></a>
  </div> <!-- method -->
  <hr/>

  <h2><a name="__Models">Models</a></h2>
  [ Jump to <a href="#__Methods">Methods</a> ]

  <h3>Table of Contents</h3>
  <ol>
    <li><a href="#Armazem"><code>Armazem</code></a></li>
    <li><a href="#Base"><code>Base</code></a></li>
    <li><a href="#Consumidor"><code>Consumidor</code></a></li>
    <li><a href="#Encomenda"><code>Encomenda</code></a></li>
    <li><a href="#Fornecedor"><code>Fornecedor</code></a></li>
    <li><a href="#Produto"><code>Produto</code></a></li>
    <li><a href="#Transportadora"><code>Transportadora</code></a></li>
  </ol>

  <div class="model">
    <h3><a name="Armazem"><code>Armazem</code></a> <a class="up" href="#__Models">Up</a></h3>
    
    <div class="field-items">
      <div class="param">ID (optional)</div><div class="param-desc"><span class="param-type"><a href="#integer">Integer</a></span>  </div>
<div class="param">Morada (optional)</div><div class="param-desc"><span class="param-type"><a href="#string">String</a></span>  </div>
<div class="param">Fornecedor ID (optional)</div><div class="param-desc"><span class="param-type"><a href="#integer">Integer</a></span>  </div>
    </div>  <!-- field-items -->
  </div>
  <div class="model">
    <h3><a name="Base"><code>Base</code></a> <a class="up" href="#__Models">Up</a></h3>
    
    <div class="field-items">
      <div class="param">ID (optional)</div><div class="param-desc"><span class="param-type"><a href="#integer">Integer</a></span>  </div>
<div class="param">Morada (optional)</div><div class="param-desc"><span class="param-type"><a href="#string">String</a></span>  </div>
<div class="param">Transportadora ID (optional)</div><div class="param-desc"><span class="param-type"><a href="#integer">Integer</a></span>  </div>
<div class="param">Telefone (optional)</div><div class="param-desc"><span class="param-type"><a href="#integer">Integer</a></span>  </div>
    </div>  <!-- field-items -->
  </div>
  <div class="model">
    <h3><a name="Consumidor"><code>Consumidor</code></a> <a class="up" href="#__Models">Up</a></h3>
    
    <div class="field-items">
      <div class="param">ID (optional)</div><div class="param-desc"><span class="param-type"><a href="#integer">Integer</a></span>  </div>
<div class="param">Nome (optional)</div><div class="param-desc"><span class="param-type"><a href="#string">String</a></span>  </div>
<div class="param">Email (optional)</div><div class="param-desc"><span class="param-type"><a href="#string">String</a></span>  </div>
<div class="param">Password (optional)</div><div class="param-desc"><span class="param-type"><a href="#string">String</a></span>  </div>
<div class="param">Morada (optional)</div><div class="param-desc"><span class="param-type"><a href="#string">String</a></span>  </div>
<div class="param">NIF (optional)</div><div class="param-desc"><span class="param-type"><a href="#integer">Integer</a></span>  </div>
<div class="param">Telefone (optional)</div><div class="param-desc"><span class="param-type"><a href="#integer">Integer</a></span>  </div>
    </div>  <!-- field-items -->
  </div>
  <div class="model">
    <h3><a name="Encomenda"><code>Encomenda</code></a> <a class="up" href="#__Models">Up</a></h3>
    
    <div class="field-items">
      <div class="param">ID (optional)</div><div class="param-desc"><span class="param-type"><a href="#integer">Integer</a></span>  </div>
<div class="param">Preço (optional)</div><div class="param-desc"><span class="param-type"><a href="#integer">Integer</a></span>  </div>
<div class="param">Morada de Entrega (optional)</div><div class="param-desc"><span class="param-type"><a href="#string">String</a></span>  </div>
<div class="param">Quantidade (optional)</div><div class="param-desc"><span class="param-type"><a href="#integer">Integer</a></span>  </div>
<div class="param">Data Realizada (optional)</div><div class="param-desc"><span class="param-type"><a href="#date">date</a></span>  format: date</div>
<div class="param">Data Finalizada (optional)</div><div class="param-desc"><span class="param-type"><a href="#date">date</a></span>  format: date</div>
<div class="param">Consumidor ID (optional)</div><div class="param-desc"><span class="param-type"><a href="#integer">Integer</a></span>  </div>
<div class="param">Produto ID (optional)</div><div class="param-desc"><span class="param-type"><a href="#integer">Integer</a></span>  </div>
<div class="param">Transportadora ID (optional)</div><div class="param-desc"><span class="param-type"><a href="#integer">Integer</a></span>  </div>
<div class="param">EstadoDaEncomenda (optional)</div><div class="param-desc"><span class="param-type"><a href="#string">String</a></span> Estado atual da encomenda </div>
        <div class="param-enum-header">Enum:</div>
        <div class="param-enum">confirmada</div><div class="param-enum">paga</div><div class="param-enum">Periodo de Cancelamento</div><div class="param-enum">pendente de envio</div><div class="param-enum">expedida</div><div class="param-enum">em distribuição</div><div class="param-enum">entregue</div>
    </div>  <!-- field-items -->
  </div>
  <div class="model">
    <h3><a name="Fornecedor"><code>Fornecedor</code></a> <a class="up" href="#__Models">Up</a></h3>
    
    <div class="field-items">
      <div class="param">ID (optional)</div><div class="param-desc"><span class="param-type"><a href="#integer">Integer</a></span>  </div>
<div class="param">Nome (optional)</div><div class="param-desc"><span class="param-type"><a href="#string">String</a></span>  </div>
<div class="param">Email (optional)</div><div class="param-desc"><span class="param-type"><a href="#string">String</a></span>  </div>
<div class="param">Password (optional)</div><div class="param-desc"><span class="param-type"><a href="#string">String</a></span>  </div>
<div class="param">Morada (optional)</div><div class="param-desc"><span class="param-type"><a href="#string">String</a></span>  </div>
<div class="param">NIF (optional)</div><div class="param-desc"><span class="param-type"><a href="#integer">Integer</a></span>  </div>
<div class="param">Telefone (optional)</div><div class="param-desc"><span class="param-type"><a href="#integer">Integer</a></span>  </div>
    </div>  <!-- field-items -->
  </div>
  <div class="model">
    <h3><a name="Produto"><code>Produto</code></a> <a class="up" href="#__Models">Up</a></h3>
    
    <div class="field-items">
      <div class="param">ID (optional)</div><div class="param-desc"><span class="param-type"><a href="#integer">Integer</a></span>  </div>
<div class="param">Nome (optional)</div><div class="param-desc"><span class="param-type"><a href="#string">String</a></span>  </div>
<div class="param">Preco (optional)</div><div class="param-desc"><span class="param-type"><a href="#integer">Integer</a></span>  </div>
<div class="param">Data de Produção do Produto (optional)</div><div class="param-desc"><span class="param-type"><a href="#date">date</a></span>  format: date</div>
<div class="param">Date de inserção no site (optional)</div><div class="param-desc"><span class="param-type"><a href="#date">date</a></span>  format: date</div>
<div class="param">Poluição gerada por dia (optional)</div><div class="param-desc"><span class="param-type"><a href="#string">String</a></span>  </div>
<div class="param">Informação Arbitrária (optional)</div><div class="param-desc"><span class="param-type"><a href="#string">String</a></span>  </div>
<div class="param">Armazem ID (optional)</div><div class="param-desc"><span class="param-type"><a href="#integer">Integer</a></span>  </div>
<div class="param">Fornecedor ID (optional)</div><div class="param-desc"><span class="param-type"><a href="#integer">Integer</a></span>  </div>
<div class="param">Categoria (optional)</div><div class="param-desc"><span class="param-type"><a href="#string">String</a></span>  </div>
<div class="param">Subcategoria (optional)</div><div class="param-desc"><span class="param-type"><a href="#string">String</a></span>  </div>
    </div>  <!-- field-items -->
  </div>
  <div class="model">
    <h3><a name="Transportadora"><code>Transportadora</code></a> <a class="up" href="#__Models">Up</a></h3>
    
    <div class="field-items">
      <div class="param">ID (optional)</div><div class="param-desc"><span class="param-type"><a href="#integer">Integer</a></span>  </div>
<div class="param">Nome (optional)</div><div class="param-desc"><span class="param-type"><a href="#string">String</a></span>  </div>
<div class="param">Email (optional)</div><div class="param-desc"><span class="param-type"><a href="#string">String</a></span>  </div>
<div class="param">Password (optional)</div><div class="param-desc"><span class="param-type"><a href="#string">String</a></span>  </div>
<div class="param">Morada (optional)</div><div class="param-desc"><span class="param-type"><a href="#string">String</a></span>  </div>
<div class="param">NIF (optional)</div><div class="param-desc"><span class="param-type"><a href="#integer">Integer</a></span>  </div>
<div class="param">Telefone (optional)</div><div class="param-desc"><span class="param-type"><a href="#integer">Integer</a></span>  </div>
    </div>  <!-- field-items -->
  </div>
  </body>
</html>
