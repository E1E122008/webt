# Social Media Component

Komponen Blade untuk menampilkan link media sosial dengan data dari pengaturan admin.

## Penggunaan

```blade
<x-social-media 
    :show-title="true"
    title="Ikuti Kami"
    subtitle="Ikuti media sosial kami untuk informasi terbaru"
    size="normal"
    layout="cards"
/>
```

## Parameter

- `showTitle` (boolean): Menampilkan judul dan subtitle
- `title` (string): Judul komponen
- `subtitle` (string): Subtitle komponen
- `size` (string): Ukuran komponen (`small`, `normal`, `large`)
- `layout` (string): Layout komponen (`cards`, `buttons`, `list`)

## Data Source

Komponen mengambil data dari `SettingsHelper::get('social_media', [])` dengan struktur:

```php
[
    'facebook' => 'https://facebook.com/username',
    'facebook_handle' => 'Username',
    'instagram' => 'https://instagram.com/username',
    'instagram_handle' => 'username',
    'youtube' => 'https://youtube.com/@username',
    'youtube_handle' => 'Channel Name',
    'whatsapp' => 'https://wa.me/6281234567890',
    'whatsapp_number' => '+62 812-3456-7890'
]
```

## Styling

CSS terpisah di `public/css/components/social-media.css` dengan:
- Layout card responsif
- Warna platform sesuai brand
- Hover effects yang smooth
- Support untuk berbagai ukuran
