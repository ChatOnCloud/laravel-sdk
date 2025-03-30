# ChatOnCloud Laravel SDK

SDK Laravel oficial para integração com a plataforma ChatOnCloud.

Atualmente permite **criar chamados remotamente via API**. Futuramente será expandido com novas funcionalidades.

---

## 📦 Instalação

1. Adicione o pacote via Composer:

```bash
composer require chatoncloud/laravel-sdk
```

2. Publique o arquivo de configuração:

```bash
php artisan vendor:publish --tag=chatoncloud-config
```

3. Configure as variáveis de ambiente no seu `.env`:

```env
CHATONCLOUD_URL=https://chatoncloud.com
CHATONCLOUD_TOKEN=seu_token_secreto
```

---

## ⚙️ Exemplo de uso

```php
use ChatOnCloud\Ticket\TicketClient;

$response = app(TicketClient::class)->create(
    sSubject: 'Problema com login',
    sDescription: 'Usuário relatou erro 500 ao tentar acessar.',
    sPriority: 'alta',
    aAttachments: [$arquivo1, $arquivo2] // Opcional
);

if ($response) {
    echo "Chamado criado com sucesso! ID: " . $response['ticket_id'];
} else {
    echo "Erro ao criar o chamado.";
}
```

---

## 📁 Estrutura do Config

Arquivo `config/chatoncloud.php` publicado:

```php
return [
    'url' => env('CHATONCLOUD_URL', 'https://dominio.com/api/tickets'),
    'token' => env('CHATONCLOUD_TOKEN'),
];
```

---

## 🛠️ Requisitos

- PHP >= 8.1
- Laravel >= 10
- GuzzleHTTP (instalado automaticamente)

---

## 🤝 Contribuindo

Pull requests são bem-vindos! Este pacote será continuamente evoluído conforme novas integrações forem sendo implementadas na plataforma ChatOnCloud.
