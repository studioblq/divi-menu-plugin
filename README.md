# Divi Custom Menu Module

Plugin semplice che aggiunge un modulo Divi per visualizzare menu WordPress in orientamento orizzontale o verticale, senza effetto hamburger.

## Caratteristiche

✅ Modulo custom Divi  
✅ Selezione dinamica dei menu di WordPress  
✅ Orientamento orizzontale o verticale  
✅ Controlli di styling integrati (colori, dimensioni, spaziatura)  
✅ Visual Builder support  
✅ Responsive design  

## Struttura del Plugin

```
divi-menu-plugin/
├── divi-menu-plugin.php       (File principale)
├── includes/
│   └── DiviMenuModule.php     (Classe del modulo Divi)
├── css/
│   └── style.css              (Stili CSS)
└── README.md                  (Questo file)
```

## Installazione

1. **Crea una cartella** sul tuo server: `/wp-content/plugins/divi-menu-plugin/`

2. **Carica i file**:
   - `divi-menu-plugin.php` nella root della cartella
   - Crea la cartella `includes/` e carica `DiviMenuModule.php`
   - Crea la cartella `css/` e carica `style.css`

3. **Attiva il plugin** da WordPress → Plugins

4. **Verifica**: Se vedi il modulo "Custom Menu" in Divi Builder, è tutto ok!

## Utilizzo

1. **Aggiungi un modulo** in Divi:
   - Clicca su "+" nel builder
   - Cerca "Custom Menu"
   - Clicca per aggiungerlo

2. **Configura il modulo**:
   - **Impostazioni Generali**:
     - Seleziona il menu da visualizzare
     - Scegli orientamento (orizzontale o verticale)
   
   - **Stile** (Tab Avanzate):
     - Colore testo
     - Colore al hover
     - Dimensione font
     - Spazio tra elementi
     - Padding degli elementi

3. **Salva** - Il menu comparirà sulla pagina!

## Opzioni di Configurazione

### Generali
- **Seleziona Menu**: Dropdown con tutti i menu di WordPress registrati
- **Orientamento**: Orizzontale (predefinito) o Verticale

### Styling
- **Colore Testo**: Colore dei link del menu
- **Colore al Hover**: Colore quando passi il mouse
- **Dimensione Font**: Da 10px a 48px
- **Spazio tra Elementi**: Distanza tra i link (0-100px)
- **Padding Elementi**: Spazio interno dei link (0-50px)

## Note Tecniche

- Il modulo carica i menu tramite `wp_get_nav_menus()`
- Usa `wp_nav_menu()` per renderizzare
- Solo profondità 1 (no sottomenu)
- CSS con Flexbox per layout reattivo
- Full Visual Builder support

## Personalizzazioni Avanzate

Se vuoi aggiungere supporto per sottomenu, modifica in `DiviMenuModule.php`:

```php
'depth' => 2,  // Cambio da 1 a 2 per attivare sottomenu
```

## Compatibilità

- ✅ Divi 4.x+
- ✅ WordPress 5.5+
- ✅ PHP 7.2+

## Supporto

Qualsiasi issue o personalizzazione, fammi sapere!

## Licenza

GPL2 - Libero di usare e modificare.
