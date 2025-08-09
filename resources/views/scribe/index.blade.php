<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Laravel API Documentation</title>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.style.css") }}" media="screen">
    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.print.css") }}" media="print">

    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.10/lodash.min.js"></script>

    <link rel="stylesheet"
          href="https://unpkg.com/@highlightjs/cdn-assets@11.6.0/styles/obsidian.min.css">
    <script src="https://unpkg.com/@highlightjs/cdn-assets@11.6.0/highlight.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jets/0.14.1/jets.min.js"></script>

    <style id="language-style">
        /* starts out as display none and is replaced with js later  */
                    body .content .bash-example code { display: none; }
                    body .content .javascript-example code { display: none; }
            </style>

    <script>
        var tryItOutBaseUrl = "http://localhost:8000";
        var useCsrf = Boolean();
        var csrfUrl = "/sanctum/csrf-cookie";
    </script>
    <script src="{{ asset("/vendor/scribe/js/tryitout-5.3.0.js") }}"></script>

    <script src="{{ asset("/vendor/scribe/js/theme-default-5.3.0.js") }}"></script>

</head>

<body data-languages="[&quot;bash&quot;,&quot;javascript&quot;]">

<a href="#" id="nav-button">
    <span>
        MENU
        <img src="{{ asset("/vendor/scribe/images/navbar.png") }}" alt="navbar-image"/>
    </span>
</a>
<div class="tocify-wrapper">
    
            <div class="lang-selector">
                                            <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                            <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                    </div>
    
    <div class="search">
        <input type="text" class="search" id="input-search" placeholder="Search">
    </div>

    <div id="toc">
                    <ul id="tocify-header-introduction" class="tocify-header">
                <li class="tocify-item level-1" data-unique="introduction">
                    <a href="#introduction">Introduction</a>
                </li>
                            </ul>
                    <ul id="tocify-header-authenticating-requests" class="tocify-header">
                <li class="tocify-item level-1" data-unique="authenticating-requests">
                    <a href="#authenticating-requests">Authenticating requests</a>
                </li>
                            </ul>
                    <ul id="tocify-header-auth" class="tocify-header">
                <li class="tocify-item level-1" data-unique="auth">
                    <a href="#auth">Auth</a>
                </li>
                                    <ul id="tocify-subheader-auth" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="auth-POSTapi-login">
                                <a href="#auth-POSTapi-login">Login</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="auth-POSTapi-logout">
                                <a href="#auth-POSTapi-logout">Logout</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-dashboard" class="tocify-header">
                <li class="tocify-item level-1" data-unique="dashboard">
                    <a href="#dashboard">Dashboard</a>
                </li>
                                    <ul id="tocify-subheader-dashboard" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="dashboard-GETapi-dashboard">
                                <a href="#dashboard-GETapi-dashboard">GET /dashboard → métricas do dashboard</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-events" class="tocify-header">
                <li class="tocify-item level-1" data-unique="events">
                    <a href="#events">Events</a>
                </li>
                                    <ul id="tocify-subheader-events" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="events-GETapi-events">
                                <a href="#events-GETapi-events">GET /events → últimos eventos com filtros</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="events-GETapi-events-summary">
                                <a href="#events-GETapi-events-summary">GET /events/summary → resumo de eventos por categoria/tipo</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-items" class="tocify-header">
                <li class="tocify-item level-1" data-unique="items">
                    <a href="#items">Items</a>
                </li>
                                    <ul id="tocify-subheader-items" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="items-GETapi-items-top">
                                <a href="#items-GETapi-items-top">GET /items/top → itens mais coletados</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="items-GETapi-items">
                                <a href="#items-GETapi-items">GET /items → lista todos os itens com estatísticas</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="items-GETapi-items--itemName--stats">
                                <a href="#items-GETapi-items--itemName--stats">GET /items/:name/stats → estatísticas detalhadas de um item</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-players" class="tocify-header">
                <li class="tocify-item level-1" data-unique="players">
                    <a href="#players">Players</a>
                </li>
                                    <ul id="tocify-subheader-players" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="players-GETapi-players">
                                <a href="#players-GETapi-players">GET /players → lista de jogadores com dados básicos</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="players-GETapi-players--playerId--stats">
                                <a href="#players-GETapi-players--playerId--stats">GET /players/:id/stats → estatísticas de um jogador</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="players-GETapi-leaderboard">
                                <a href="#players-GETapi-leaderboard">GET /leaderboard → ranking de jogadores por pontuação</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-upload" class="tocify-header">
                <li class="tocify-item level-1" data-unique="upload">
                    <a href="#upload">Upload</a>
                </li>
                                    <ul id="tocify-subheader-upload" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="upload-POSTapi-upload">
                                <a href="#upload-POSTapi-upload">POST Enviar arquivo para processamento</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="upload-GETapi-upload--uploadedFileId--status">
                                <a href="#upload-GETapi-upload--uploadedFileId--status">GET Verificar status do processamento de um arquivo</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="upload-GETapi-uploads">
                                <a href="#upload-GETapi-uploads">GET Listar uploads com seus status</a>
                            </li>
                                                                        </ul>
                            </ul>
            </div>

    <ul class="toc-footer" id="toc-footer">
                    <li style="padding-bottom: 5px;"><a href="{{ route("scribe.postman") }}">View Postman collection</a></li>
                            <li style="padding-bottom: 5px;"><a href="{{ route("scribe.openapi") }}">View OpenAPI spec</a></li>
                <li><a href="http://github.com/knuckleswtf/scribe">Documentation powered by Scribe ✍</a></li>
    </ul>

    <ul class="toc-footer" id="last-updated">
        <li>Last updated: August 9, 2025</li>
    </ul>
</div>

<div class="page-wrapper">
    <div class="dark-box"></div>
    <div class="content">
        <h1 id="introduction">Introduction</h1>
<aside>
    <strong>Base URL</strong>: <code>http://localhost:8000</code>
</aside>
<pre><code>This documentation aims to provide all the information you need to work with our API.

&lt;aside&gt;As you scroll, you'll see code examples for working with the API in different programming languages in the dark area to the right (or as part of the content on mobile).
You can switch the language used with the tabs at the top right (or from the nav menu at the top left on mobile).&lt;/aside&gt;</code></pre>

        <h1 id="authenticating-requests">Authenticating requests</h1>
<p>This API is not authenticated.</p>

        <h1 id="auth">Auth</h1>

    

                                <h2 id="auth-POSTapi-login">Login</h2>

<p>
</p>



<span id="example-requests-POSTapi-login">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost:8000/api/login?email=gbailey%40example.net&amp;password=%7C%5D%7C%7B%2B-" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"email\": \"gbailey@example.net\",
    \"password\": \"architecto\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/login"
);

const params = {
    "email": "gbailey@example.net",
    "password": "|]|{+-",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "email": "gbailey@example.net",
    "password": "architecto"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-login">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;token&quot;: &quot;1234567890&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-login" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-login"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-login"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-login" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-login">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-login" data-method="POST"
      data-path="api/login"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-login', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-login"
                    onclick="tryItOut('POSTapi-login');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-login"
                    onclick="cancelTryOut('POSTapi-login');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-login"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/login</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-login"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-login"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="email"                data-endpoint="POSTapi-login"
               value="gbailey@example.net"
               data-component="query">
    <br>
<p>O email do usuário. Example: <code>gbailey@example.net</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>password</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="password"                data-endpoint="POSTapi-login"
               value="|]|{+-"
               data-component="query">
    <br>
<p>A senha do usuário. Example: <code>|]|{+-</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="email"                data-endpoint="POSTapi-login"
               value="gbailey@example.net"
               data-component="body">
    <br>
<p>Must be a valid email address. Example: <code>gbailey@example.net</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>password</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="password"                data-endpoint="POSTapi-login"
               value="architecto"
               data-component="body">
    <br>
<p>Example: <code>architecto</code></p>
        </div>
        </form>

                    <h2 id="auth-POSTapi-logout">Logout</h2>

<p>
</p>



<span id="example-requests-POSTapi-logout">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost:8000/api/logout" \
    --header "Authorization: Bearer {token}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/logout"
);

const headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-logout">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Logged out successfully&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-logout" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-logout"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-logout"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-logout" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-logout">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-logout" data-method="POST"
      data-path="api/logout"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-logout', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-logout"
                    onclick="tryItOut('POSTapi-logout');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-logout"
                    onclick="cancelTryOut('POSTapi-logout');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-logout"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/logout</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization"                data-endpoint="POSTapi-logout"
               value="Bearer {token}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {token}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-logout"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-logout"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                <h1 id="dashboard">Dashboard</h1>

    

                                <h2 id="dashboard-GETapi-dashboard">GET /dashboard → métricas do dashboard</h2>

<p>
</p>



<span id="example-requests-GETapi-dashboard">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/dashboard?hours=16" \
    --header "Authorization: Bearer {token}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/dashboard"
);

const params = {
    "hours": "16",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-dashboard">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;data&quot;: {
        &quot;time_range&quot;: {
            &quot;from&quot;: &quot;2025-08-09 00:00:00&quot;,
            &quot;to&quot;: &quot;2025-08-09 23:59:59&quot;,
            &quot;hours&quot;: 24
        },
        &quot;players&quot;: {
            &quot;total_players&quot;: 100,
            &quot;active_players&quot;: 50,
            &quot;new_players&quot;: 20,
            &quot;activity_rate&quot;: 50
        },
        &quot;combat&quot;: {
            &quot;total_deaths&quot;: 100,
            &quot;bosses_defeated&quot;: 50,
            &quot;players_with_most_deaths&quot;: [
                {
                    &quot;player_id&quot;: &quot;p1&quot;,
                    &quot;player_name&quot;: &quot;Jogador 1&quot;,
                    &quot;death_count&quot;: 10
                },
                {
                    &quot;player_id&quot;: &quot;p2&quot;,
                    &quot;player_name&quot;: &quot;Jogador 2&quot;,
                    &quot;death_count&quot;: 8
                }
            ]
        },
        &quot;economy&quot;: {
            &quot;total_xp_gained&quot;: 10000,
            &quot;total_gold_gained&quot;: 500,
            &quot;avg_xp_per_player&quot;: 100,
            &quot;avg_gold_per_player&quot;: 5
        },
        &quot;activity&quot;: {
            &quot;total_events&quot;: 1000,
            &quot;chat_messages&quot;: 500,
            &quot;quests_completed&quot;: 200,
            &quot;avg_events_per_hour&quot;: 41.67
        },
        &quot;items&quot;: {
            &quot;total_items_picked&quot;: 1000,
            &quot;total_pickup_events&quot;: 500,
            &quot;most_collected_items&quot;: [
                {
                    &quot;item&quot;: &quot;Item 1&quot;,
                    &quot;pickups&quot;: 100,
                    &quot;total_quantity&quot;: 500
                },
                {
                    &quot;item&quot;: &quot;Item 2&quot;,
                    &quot;pickups&quot;: 80,
                    &quot;total_quantity&quot;: 400
                }
            ]
        },
        &quot;bosses&quot;: {
            &quot;total_boss_fights&quot;: 100,
            &quot;total_boss_defeats&quot;: 50,
            &quot;bosses_defeated&quot;: [
                {
                    &quot;boss_name&quot;: &quot;Boss 1&quot;,
                    &quot;defeats&quot;: 10
                },
                {
                    &quot;boss_name&quot;: &quot;Boss 2&quot;,
                    &quot;defeats&quot;: 8
                }
            ]
        }
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-dashboard" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-dashboard"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-dashboard"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-dashboard" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-dashboard">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-dashboard" data-method="GET"
      data-path="api/dashboard"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-dashboard', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-dashboard"
                    onclick="tryItOut('GETapi-dashboard');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-dashboard"
                    onclick="cancelTryOut('GETapi-dashboard');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-dashboard"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/dashboard</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization"                data-endpoint="GETapi-dashboard"
               value="Bearer {token}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {token}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-dashboard"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-dashboard"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>hours</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="hours"                data-endpoint="GETapi-dashboard"
               value="16"
               data-component="query">
    <br>
<p>Opcional. Intervalo em horas para as métricas. Example: <code>16</code></p>
            </div>
                </form>

                <h1 id="events">Events</h1>

    

                                <h2 id="events-GETapi-events">GET /events → últimos eventos com filtros</h2>

<p>
</p>



<span id="example-requests-GETapi-events">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/events?category=architecto&amp;event_type=architecto&amp;player_id=architecto&amp;date_from=architecto&amp;date_to=architecto&amp;limit=16" \
    --header "Authorization: Bearer {token}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/events"
);

const params = {
    "category": "architecto",
    "event_type": "architecto",
    "player_id": "architecto",
    "date_from": "architecto",
    "date_to": "architecto",
    "limit": "16",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-events">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;data&quot;: [
        {
            &quot;id&quot;: 1,
            &quot;timestamp&quot;: &quot;2025-08-09T22:48:46.000000Z&quot;,
            &quot;category&quot;: &quot;combat&quot;,
            &quot;event_type&quot;: &quot;BOSS_DEFEAT&quot;,
            &quot;player_id&quot;: &quot;p1&quot;,
            &quot;player_name&quot;: &quot;Jogador 1&quot;,
            &quot;event_data&quot;: {
                &quot;boss_name&quot;: &quot;Boss 1&quot;,
                &quot;defeated_by&quot;: &quot;Jogador 2&quot;
            },
            &quot;description&quot;: &quot;Jogador 1 derrotou Boss 1&quot;
        },
        {
            &quot;id&quot;: 2,
            &quot;timestamp&quot;: &quot;2025-08-09T22:48:46.000000Z&quot;,
            &quot;category&quot;: &quot;progression&quot;,
            &quot;event_type&quot;: &quot;QUEST_COMPLETE&quot;,
            &quot;player_id&quot;: &quot;p2&quot;,
            &quot;player_name&quot;: &quot;Jogador 2&quot;,
            &quot;event_data&quot;: {
                &quot;name&quot;: &quot;Quest 1&quot;,
                &quot;quest_id&quot;: &quot;q1&quot;
            },
            &quot;description&quot;: &quot;Jogador 2 completou Quest 1&quot;
        }
    ],
    &quot;total&quot;: 2,
    &quot;limit&quot;: 50
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-events" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-events"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-events"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-events" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-events">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-events" data-method="GET"
      data-path="api/events"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-events', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-events"
                    onclick="tryItOut('GETapi-events');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-events"
                    onclick="cancelTryOut('GETapi-events');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-events"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/events</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization"                data-endpoint="GETapi-events"
               value="Bearer {token}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {token}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-events"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-events"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>category</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="category"                data-endpoint="GETapi-events"
               value="architecto"
               data-component="query">
    <br>
<p>Opcional. Categoria do evento. Example: <code>architecto</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>event_type</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="event_type"                data-endpoint="GETapi-events"
               value="architecto"
               data-component="query">
    <br>
<p>Opcional. Tipo de evento. Example: <code>architecto</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>player_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="player_id"                data-endpoint="GETapi-events"
               value="architecto"
               data-component="query">
    <br>
<p>Opcional. ID do jogador. Example: <code>architecto</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>date_from</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="date_from"                data-endpoint="GETapi-events"
               value="architecto"
               data-component="query">
    <br>
<p>Opcional. Data inicial para o filtro. Example: <code>architecto</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>date_to</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="date_to"                data-endpoint="GETapi-events"
               value="architecto"
               data-component="query">
    <br>
<p>Opcional. Data final para o filtro. Example: <code>architecto</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>limit</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="limit"                data-endpoint="GETapi-events"
               value="16"
               data-component="query">
    <br>
<p>Opcional. Número máximo de eventos a serem retornados. Example: <code>16</code></p>
            </div>
                </form>

                    <h2 id="events-GETapi-events-summary">GET /events/summary → resumo de eventos por categoria/tipo</h2>

<p>
</p>



<span id="example-requests-GETapi-events-summary">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/events/summary?date_from=architecto&amp;date_to=architecto" \
    --header "Authorization: Bearer {token}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/events/summary"
);

const params = {
    "date_from": "architecto",
    "date_to": "architecto",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-events-summary">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;data&quot;: {
        &quot;total_events&quot;: 100,
        &quot;date_range&quot;: {
            &quot;from&quot;: &quot;2025-08-01 00:00:00&quot;,
            &quot;to&quot;: &quot;2025-08-07 23:59:59&quot;
        },
        &quot;by_category&quot;: {
            &quot;combat&quot;: 30,
            &quot;progression&quot;: 20,
            &quot;social&quot;: 15,
            &quot;other&quot;: 35
        },
        &quot;by_event_type&quot;: {
            &quot;BOSS_DEFEAT&quot;: 30,
            &quot;QUEST_COMPLETE&quot;: 20,
            &quot;ITEM_PICKUP&quot;: 15,
            &quot;DEATH&quot;: 35
        },
        &quot;most_active_players&quot;: [
            {
                &quot;player_id&quot;: &quot;p1&quot;,
                &quot;player_name&quot;: &quot;Jogador 1&quot;,
                &quot;total_events&quot;: 100
            },
            {
                &quot;player_id&quot;: &quot;p2&quot;,
                &quot;player_name&quot;: &quot;Jogador 2&quot;,
                &quot;total_events&quot;: 80
            }
        }
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-events-summary" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-events-summary"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-events-summary"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-events-summary" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-events-summary">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-events-summary" data-method="GET"
      data-path="api/events/summary"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-events-summary', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-events-summary"
                    onclick="tryItOut('GETapi-events-summary');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-events-summary"
                    onclick="cancelTryOut('GETapi-events-summary');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-events-summary"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/events/summary</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization"                data-endpoint="GETapi-events-summary"
               value="Bearer {token}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {token}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-events-summary"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-events-summary"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>date_from</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="date_from"                data-endpoint="GETapi-events-summary"
               value="architecto"
               data-component="query">
    <br>
<p>Opcional. Data inicial para o resumo. Example: <code>architecto</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>date_to</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="date_to"                data-endpoint="GETapi-events-summary"
               value="architecto"
               data-component="query">
    <br>
<p>Opcional. Data final para o resumo. Example: <code>architecto</code></p>
            </div>
                </form>

                <h1 id="items">Items</h1>

    

                                <h2 id="items-GETapi-items-top">GET /items/top → itens mais coletados</h2>

<p>
</p>



<span id="example-requests-GETapi-items-top">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/items/top?limit=16&amp;sort_by=architecto" \
    --header "Authorization: Bearer {token}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/items/top"
);

const params = {
    "limit": "16",
    "sort_by": "architecto",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-items-top">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;data&quot;: {
        &quot;sorted_by&quot;: &quot;total_pickups&quot;,
        &quot;items&quot;: [
            {
                &quot;rank&quot;: 1,
                &quot;name&quot;: &quot;Item 1&quot;,
                &quot;total_pickups&quot;: 100,
                &quot;total_quantity&quot;: 500,
                &quot;avg_quantity_per_pickup&quot;: 5
            },
            {
                &quot;rank&quot;: 2,
                &quot;name&quot;: &quot;Item 2&quot;,
                &quot;total_pickups&quot;: 80,
                &quot;total_quantity&quot;: 400,
                &quot;avg_quantity_per_pickup&quot;: 5
            }
        ]
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-items-top" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-items-top"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-items-top"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-items-top" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-items-top">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-items-top" data-method="GET"
      data-path="api/items/top"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-items-top', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-items-top"
                    onclick="tryItOut('GETapi-items-top');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-items-top"
                    onclick="cancelTryOut('GETapi-items-top');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-items-top"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/items/top</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization"                data-endpoint="GETapi-items-top"
               value="Bearer {token}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {token}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-items-top"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-items-top"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>limit</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="limit"                data-endpoint="GETapi-items-top"
               value="16"
               data-component="query">
    <br>
<p>Opcional. Número máximo de itens a serem exibidos. Example: <code>16</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>sort_by</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="sort_by"                data-endpoint="GETapi-items-top"
               value="architecto"
               data-component="query">
    <br>
<p>Opcional. Campo pelo qual a lista será ordenada. Example: <code>architecto</code></p>
            </div>
                </form>

                    <h2 id="items-GETapi-items">GET /items → lista todos os itens com estatísticas</h2>

<p>
</p>



<span id="example-requests-GETapi-items">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/items?search=architecto&amp;sort_by=architecto&amp;sort_dir=architecto&amp;per_page=16&amp;page=16" \
    --header "Authorization: Bearer {token}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/items"
);

const params = {
    "search": "architecto",
    "sort_by": "architecto",
    "sort_dir": "architecto",
    "per_page": "16",
    "page": "16",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-items">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;data&quot;: {
        &quot;items&quot;: [
            {
                &quot;name&quot;: &quot;Item 1&quot;,
                &quot;total_pickups&quot;: 100,
                &quot;total_quantity&quot;: 500,
                &quot;avg_quantity_per_pickup&quot;: 5
            },
            {
                &quot;name&quot;: &quot;Item 2&quot;,
                &quot;total_pickups&quot;: 80,
                &quot;total_quantity&quot;: 400,
                &quot;avg_quantity_per_pickup&quot;: 5
            }
        ],
        &quot;pagination&quot;: {
            &quot;current_page&quot;: 1,
            &quot;last_page&quot;: 1,
            &quot;per_page&quot;: 20,
            &quot;total&quot;: 2
        }
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-items" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-items"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-items"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-items" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-items">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-items" data-method="GET"
      data-path="api/items"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-items', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-items"
                    onclick="tryItOut('GETapi-items');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-items"
                    onclick="cancelTryOut('GETapi-items');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-items"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/items</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization"                data-endpoint="GETapi-items"
               value="Bearer {token}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {token}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-items"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-items"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>search</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="search"                data-endpoint="GETapi-items"
               value="architecto"
               data-component="query">
    <br>
<p>Opcional. Nome do item a ser buscado. Example: <code>architecto</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>sort_by</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="sort_by"                data-endpoint="GETapi-items"
               value="architecto"
               data-component="query">
    <br>
<p>Opcional. Campo pelo qual a lista será ordenada. Example: <code>architecto</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>sort_dir</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="sort_dir"                data-endpoint="GETapi-items"
               value="architecto"
               data-component="query">
    <br>
<p>Opcional. Direção da ordenação. Example: <code>architecto</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>per_page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="per_page"                data-endpoint="GETapi-items"
               value="16"
               data-component="query">
    <br>
<p>Opcional. Número de itens por página. Example: <code>16</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="page"                data-endpoint="GETapi-items"
               value="16"
               data-component="query">
    <br>
<p>Opcional. Número da página a ser exibida. Example: <code>16</code></p>
            </div>
                </form>

                    <h2 id="items-GETapi-items--itemName--stats">GET /items/:name/stats → estatísticas detalhadas de um item</h2>

<p>
</p>



<span id="example-requests-GETapi-items--itemName--stats">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/items/architecto/stats?item_name=architecto" \
    --header "Authorization: Bearer {token}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/items/architecto/stats"
);

const params = {
    "item_name": "architecto",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-items--itemName--stats">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;data&quot;: {
        &quot;item_info&quot;: {
            &quot;name&quot;: &quot;Item 1&quot;,
            &quot;total_pickups&quot;: 100,
            &quot;total_quantity&quot;: 500,
            &quot;avg_quantity_per_pickup&quot;: 5
        },
        &quot;top_collectors&quot;: [
            {
                &quot;player_id&quot;: &quot;p1&quot;,
                &quot;player_name&quot;: &quot;Jogador 1&quot;,
                &quot;total_pickups&quot;: 100,
                &quot;total_quantity&quot;: 500,
                &quot;last_pickup&quot;: &quot;2025-08-09T22:48:46.000000Z&quot;
            },
            {
                &quot;player_id&quot;: &quot;p2&quot;,
                &quot;player_name&quot;: &quot;Jogador 2&quot;,
                &quot;total_pickups&quot;: 80,
                &quot;total_quantity&quot;: 400,
                &quot;last_pickup&quot;: &quot;2025-08-09T22:48:46.000000Z&quot;
            }
        ],
        &quot;pickup_locations&quot;: [
            {
                &quot;location&quot;: &quot;Zona 1&quot;,
                &quot;total_pickups&quot;: 100,
                &quot;total_quantity&quot;: 500
            },
            {
                &quot;location&quot;: &quot;Zona 2&quot;,
                &quot;total_pickups&quot;: 80,
                &quot;total_quantity&quot;: 400
            }
        ],
        &quot;recent_pickups&quot;: [
            {
                &quot;timestamp&quot;: &quot;2025-08-09T22:48:46.000000Z&quot;,
                &quot;player_id&quot;: &quot;p1&quot;,
                &quot;player_name&quot;: &quot;Jogador 1&quot;,
                &quot;quantity&quot;: 10,
                &quot;location&quot;: &quot;Zona 1&quot;
            },
            {
                &quot;timestamp&quot;: &quot;2025-08-09T22:48:46.000000Z&quot;,
                &quot;player_id&quot;: &quot;p2&quot;,
                &quot;player_name&quot;: &quot;Jogador 2&quot;,
                &quot;quantity&quot;: 5,
                &quot;location&quot;: &quot;Zona 2&quot;
            }
        }
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-items--itemName--stats" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-items--itemName--stats"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-items--itemName--stats"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-items--itemName--stats" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-items--itemName--stats">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-items--itemName--stats" data-method="GET"
      data-path="api/items/{itemName}/stats"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-items--itemName--stats', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-items--itemName--stats"
                    onclick="tryItOut('GETapi-items--itemName--stats');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-items--itemName--stats"
                    onclick="cancelTryOut('GETapi-items--itemName--stats');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-items--itemName--stats"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/items/{itemName}/stats</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization"                data-endpoint="GETapi-items--itemName--stats"
               value="Bearer {token}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {token}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-items--itemName--stats"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-items--itemName--stats"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>itemName</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="itemName"                data-endpoint="GETapi-items--itemName--stats"
               value="architecto"
               data-component="url">
    <br>
<p>Example: <code>architecto</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>item_name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="item_name"                data-endpoint="GETapi-items--itemName--stats"
               value="architecto"
               data-component="query">
    <br>
<p>O nome do item. Example: <code>architecto</code></p>
            </div>
                </form>

                <h1 id="players">Players</h1>

    

                                <h2 id="players-GETapi-players">GET /players → lista de jogadores com dados básicos</h2>

<p>
</p>



<span id="example-requests-GETapi-players">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/players?level_min=16&amp;level_max=16&amp;zone=architecto&amp;sort_by=architecto&amp;sort_dir=architecto&amp;per_page=16&amp;page=16" \
    --header "Authorization: Bearer {token}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/players"
);

const params = {
    "level_min": "16",
    "level_max": "16",
    "zone": "architecto",
    "sort_by": "architecto",
    "sort_dir": "architecto",
    "per_page": "16",
    "page": "16",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-players">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;data&quot;: [
        {
            &quot;id&quot;: 1,
            &quot;player_id&quot;: &quot;p2&quot;,
            &quot;name&quot;: &quot;\&quot;Quest&quot;,
            &quot;level&quot;: 25,
            &quot;current_zone&quot;: &quot;AncientRuins&quot;,
            &quot;total_score&quot;: 0,
            &quot;total_xp&quot;: 0,
            &quot;total_gold&quot;: 0,
            &quot;deaths&quot;: 0,
            &quot;kills&quot;: 0,
            &quot;bosses_defeated&quot;: 0,
            &quot;quests_completed&quot;: 0,
            &quot;last_seen&quot;: &quot;2025-08-09T22:48:46.000000Z&quot;,
            &quot;created_at&quot;: &quot;2025-08-09T22:48:39.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2025-08-09T22:48:46.000000Z&quot;
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-players" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-players"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-players"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-players" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-players">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-players" data-method="GET"
      data-path="api/players"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-players', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-players"
                    onclick="tryItOut('GETapi-players');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-players"
                    onclick="cancelTryOut('GETapi-players');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-players"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/players</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization"                data-endpoint="GETapi-players"
               value="Bearer {token}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {token}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-players"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-players"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>level_min</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="level_min"                data-endpoint="GETapi-players"
               value="16"
               data-component="query">
    <br>
<p>Opcional. Nível mínimo dos jogadores a serem listados. Example: <code>16</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>level_max</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="level_max"                data-endpoint="GETapi-players"
               value="16"
               data-component="query">
    <br>
<p>Opcional. Nível máximo dos jogadores a serem listados. Example: <code>16</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>zone</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="zone"                data-endpoint="GETapi-players"
               value="architecto"
               data-component="query">
    <br>
<p>Opcional. Zona a ser filtrada. Example: <code>architecto</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>sort_by</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="sort_by"                data-endpoint="GETapi-players"
               value="architecto"
               data-component="query">
    <br>
<p>Opcional. Campo pelo qual a lista será ordenada. Example: <code>architecto</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>sort_dir</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="sort_dir"                data-endpoint="GETapi-players"
               value="architecto"
               data-component="query">
    <br>
<p>Opcional. Direção da ordenação. Example: <code>architecto</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>per_page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="per_page"                data-endpoint="GETapi-players"
               value="16"
               data-component="query">
    <br>
<p>Opcional. Número de jogadores por página. Example: <code>16</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="page"                data-endpoint="GETapi-players"
               value="16"
               data-component="query">
    <br>
<p>Opcional. Número da página a ser exibida. Example: <code>16</code></p>
            </div>
                </form>

                    <h2 id="players-GETapi-players--playerId--stats">GET /players/:id/stats → estatísticas de um jogador</h2>

<p>
</p>



<span id="example-requests-GETapi-players--playerId--stats">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/players/architecto/stats?player_id=architecto" \
    --header "Authorization: Bearer {token}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/players/architecto/stats"
);

const params = {
    "player_id": "architecto",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-players--playerId--stats">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;data&quot;: {
        &quot;player_info&quot;: {
            &quot;player_id&quot;: &quot;p2&quot;,
            &quot;name&quot;: &quot;\&quot;Quest&quot;,
            &quot;level&quot;: 25,
            &quot;current_zone&quot;: &quot;AncientRuins&quot;,
            &quot;total_score&quot;: 0,
            &quot;total_xp&quot;: 0,
            &quot;total_gold&quot;: 0,
            &quot;deaths&quot;: 0,
            &quot;kills&quot;: 0,
            &quot;bosses_defeated&quot;: 0,
            &quot;quests_completed&quot;: 0,
            &quot;last_seen&quot;: &quot;2025-08-09T22:48:46.000000Z&quot;,
            &quot;created_at&quot;: &quot;2025-08-09T22:48:39.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2025-08-09T22:48:46.000000Z&quot;
        },
        &quot;combat_stats&quot;: {
            &quot;total_score&quot;: 0,
            &quot;kills&quot;: 0,
            &quot;deaths&quot;: 0,
            &quot;kd_ratio&quot;: 0,
            &quot;bosses_defeated&quot;: 0
        },
        &quot;progression_stats&quot;: {
            &quot;total_xp&quot;: 0,
            &quot;total_gold&quot;: 0,
            &quot;quests_completed&quot;: 0
        },
        &quot;activity_stats&quot;: {
            &quot;total_events&quot;: 0,
            &quot;chat_messages&quot;: 0,
            &quot;items_collected&quot;: 0,
            &quot;zones_visited&quot;: 0
        },
        &quot;recent_activity&quot;: [
            {
                &quot;timestamp&quot;: &quot;2025-08-09T22:48:46.000000Z&quot;,
                &quot;category&quot;: &quot;combat&quot;,
                &quot;event_type&quot;: &quot;BOSS_DEFEAT&quot;,
                &quot;description&quot;: &quot;Derrotou Boss e ganhou 0 XP e 0 gold&quot;
            }
        ]
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-players--playerId--stats" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-players--playerId--stats"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-players--playerId--stats"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-players--playerId--stats" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-players--playerId--stats">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-players--playerId--stats" data-method="GET"
      data-path="api/players/{playerId}/stats"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-players--playerId--stats', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-players--playerId--stats"
                    onclick="tryItOut('GETapi-players--playerId--stats');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-players--playerId--stats"
                    onclick="cancelTryOut('GETapi-players--playerId--stats');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-players--playerId--stats"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/players/{playerId}/stats</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization"                data-endpoint="GETapi-players--playerId--stats"
               value="Bearer {token}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {token}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-players--playerId--stats"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-players--playerId--stats"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>playerId</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="playerId"                data-endpoint="GETapi-players--playerId--stats"
               value="architecto"
               data-component="url">
    <br>
<p>Example: <code>architecto</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>player_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="player_id"                data-endpoint="GETapi-players--playerId--stats"
               value="architecto"
               data-component="query">
    <br>
<p>O ID do jogador. Example: <code>architecto</code></p>
            </div>
                </form>

                    <h2 id="players-GETapi-leaderboard">GET /leaderboard → ranking de jogadores por pontuação</h2>

<p>
</p>



<span id="example-requests-GETapi-leaderboard">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/leaderboard?type=architecto&amp;limit=16" \
    --header "Authorization: Bearer {token}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/leaderboard"
);

const params = {
    "type": "architecto",
    "limit": "16",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-leaderboard">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;data&quot;: {
        &quot;type&quot;: &quot;score&quot;,
        &quot;leaderboard&quot;: [
            {
                &quot;rank&quot;: 1,
                &quot;player_id&quot;: &quot;p1&quot;,
                &quot;name&quot;: &quot;Jogador 1&quot;,
                &quot;level&quot;: 30,
                &quot;value&quot;: 1500,
                &quot;last_seen&quot;: &quot;2025-08-09T22:48:46.000000Z&quot;
            },
            {
                &quot;rank&quot;: 2,
                &quot;player_id&quot;: &quot;p2&quot;,
                &quot;name&quot;: &quot;Jogador 2&quot;,
                &quot;level&quot;: 28,
                &quot;value&quot;: 1200,
                &quot;last_seen&quot;: &quot;2025-08-09T22:48:46.000000Z&quot;
            }
        ]
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-leaderboard" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-leaderboard"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-leaderboard"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-leaderboard" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-leaderboard">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-leaderboard" data-method="GET"
      data-path="api/leaderboard"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-leaderboard', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-leaderboard"
                    onclick="tryItOut('GETapi-leaderboard');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-leaderboard"
                    onclick="cancelTryOut('GETapi-leaderboard');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-leaderboard"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/leaderboard</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization"                data-endpoint="GETapi-leaderboard"
               value="Bearer {token}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {token}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-leaderboard"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-leaderboard"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>type</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="type"                data-endpoint="GETapi-leaderboard"
               value="architecto"
               data-component="query">
    <br>
<p>Opcional. Tipo de ranking a ser exibido. Example: <code>architecto</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>limit</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="limit"                data-endpoint="GETapi-leaderboard"
               value="16"
               data-component="query">
    <br>
<p>Opcional. Número máximo de jogadores a serem exibidos. Example: <code>16</code></p>
            </div>
                </form>

                <h1 id="upload">Upload</h1>

    

                                <h2 id="upload-POSTapi-upload">POST Enviar arquivo para processamento</h2>

<p>
</p>



<span id="example-requests-POSTapi-upload">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://localhost:8000/api/upload" \
    --header "Authorization: Bearer {token}" \
    --header "Content-Type: multipart/form-data" \
    --header "Accept: application/json" \
    --form "file=@C:\Users\edmil\AppData\Local\Temp\phpCE6C.tmp" </code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/upload"
);

const headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "multipart/form-data",
    "Accept": "application/json",
};

const body = new FormData();
body.append('file', document.querySelector('input[name="file"]').files[0]);

fetch(url, {
    method: "POST",
    headers,
    body,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-upload">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;message&quot;: &quot;Arquivo j&aacute; foi processado anteriormente&quot;,
    &quot;data&quot;: {
        &quot;path&quot;: &quot;uploaded_logs/KSX43oS0NKfmtgfVqjVx5ybaarcbxr8veFOZUaPq.txt&quot;,
        &quot;filename&quot;: &quot;game_log_reduzido.txt&quot;,
        &quot;uploaded_file_id&quot;: 3,
        &quot;events_processed&quot;: 0,
        &quot;events_skipped&quot;: 0,
        &quot;duplicate_file&quot;: true,
        &quot;status&quot;: &quot;completed&quot;
    }
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-upload" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-upload"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-upload"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-upload" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-upload">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-upload" data-method="POST"
      data-path="api/upload"
      data-authed="0"
      data-hasfiles="1"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-upload', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-upload"
                    onclick="tryItOut('POSTapi-upload');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-upload"
                    onclick="cancelTryOut('POSTapi-upload');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-upload"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/upload</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization"                data-endpoint="POSTapi-upload"
               value="Bearer {token}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {token}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-upload"
               value="multipart/form-data"
               data-component="header">
    <br>
<p>Example: <code>multipart/form-data</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-upload"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>file</code></b>&nbsp;&nbsp;
<small>file</small>&nbsp;
 &nbsp;
                <input type="file" style="display: none"
                              name="file"                data-endpoint="POSTapi-upload"
               value=""
               data-component="body">
    <br>
<p>O arquivo de log a ser processado. Example: <code>C:\Users\edmil\AppData\Local\Temp\phpCE6C.tmp</code></p>
        </div>
        </form>

                    <h2 id="upload-GETapi-upload--uploadedFileId--status">GET Verificar status do processamento de um arquivo</h2>

<p>
</p>



<span id="example-requests-GETapi-upload--uploadedFileId--status">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/upload/architecto/status?uploadedFileId=16" \
    --header "Authorization: Bearer {token}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/upload/architecto/status"
);

const params = {
    "uploadedFileId": "16",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-upload--uploadedFileId--status">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;data&quot;: {
        &quot;id&quot;: 3,
        &quot;filename&quot;: &quot;game_log_reduzido.txt&quot;,
        &quot;status&quot;: &quot;completed&quot;,
        &quot;events_count&quot;: 0,
        &quot;created_at&quot;: &quot;2025-08-09T22:51:40.000000Z&quot;,
        &quot;processed_at&quot;: &quot;2025-08-09 22:51:45&quot;,
        &quot;processing_time&quot;: &quot;5 seconds before&quot;
    },
    &quot;message&quot;: &quot;Arquivo processado com sucesso&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-upload--uploadedFileId--status" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-upload--uploadedFileId--status"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-upload--uploadedFileId--status"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-upload--uploadedFileId--status" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-upload--uploadedFileId--status">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-upload--uploadedFileId--status" data-method="GET"
      data-path="api/upload/{uploadedFileId}/status"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-upload--uploadedFileId--status', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-upload--uploadedFileId--status"
                    onclick="tryItOut('GETapi-upload--uploadedFileId--status');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-upload--uploadedFileId--status"
                    onclick="cancelTryOut('GETapi-upload--uploadedFileId--status');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-upload--uploadedFileId--status"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/upload/{uploadedFileId}/status</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization"                data-endpoint="GETapi-upload--uploadedFileId--status"
               value="Bearer {token}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {token}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-upload--uploadedFileId--status"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-upload--uploadedFileId--status"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>uploadedFileId</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="uploadedFileId"                data-endpoint="GETapi-upload--uploadedFileId--status"
               value="architecto"
               data-component="url">
    <br>
<p>Example: <code>architecto</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>uploadedFileId</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="uploadedFileId"                data-endpoint="GETapi-upload--uploadedFileId--status"
               value="16"
               data-component="query">
    <br>
<p>O ID do arquivo de upload. Example: <code>16</code></p>
            </div>
                </form>

                    <h2 id="upload-GETapi-uploads">GET Listar uploads com seus status</h2>

<p>
</p>



<span id="example-requests-GETapi-uploads">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost:8000/api/uploads?per_page=16&amp;page=16" \
    --header "Authorization: Bearer {token}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost:8000/api/uploads"
);

const params = {
    "per_page": "16",
    "page": "16",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Authorization": "Bearer {token}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-uploads">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;data&quot;: [
        {
            &quot;id&quot;: 1,
            &quot;filename&quot;: &quot;game_log_reduzido.txt&quot;,
            &quot;status&quot;: &quot;completed&quot;,
            &quot;created_at&quot;: &quot;2023-01-01 12:00:00&quot;,
            &quot;processed_at&quot;: &quot;2023-01-01 12:05:00&quot;
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-uploads" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-uploads"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-uploads"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-uploads" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-uploads">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-uploads" data-method="GET"
      data-path="api/uploads"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-uploads', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-uploads"
                    onclick="tryItOut('GETapi-uploads');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-uploads"
                    onclick="cancelTryOut('GETapi-uploads');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-uploads"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/uploads</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization"                data-endpoint="GETapi-uploads"
               value="Bearer {token}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {token}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-uploads"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-uploads"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>per_page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="per_page"                data-endpoint="GETapi-uploads"
               value="16"
               data-component="query">
    <br>
<p>Opcional. Número de uploads por página. Example: <code>16</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="page"                data-endpoint="GETapi-uploads"
               value="16"
               data-component="query">
    <br>
<p>Opcional. Número da página a ser exibida. Example: <code>16</code></p>
            </div>
                </form>

            

        
    </div>
    <div class="dark-box">
                    <div class="lang-selector">
                                                        <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                                        <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                            </div>
            </div>
</div>
</body>
</html>
