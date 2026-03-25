# DSK Sector Viewer

> Analyseur de disquettes Amstrad CPC au format Extended DSK — visualisation des pistes, secteurs, catalogue CP/M et protections.

---

### Présentation

**DSK Sector Viewer** est une application web en PHP pur permettant d'analyser des fichiers `.dsk` au format **Extended CPC DSK** (Amstrad CPC). Elle offre une interface moderne à onglets pour explorer l'ensemble des informations contenues dans une image disquette : structure physique, catalogue de fichiers CP/M, carte visuelle des secteurs et détection des protections.

### Fonctionnalités

- **Upload sécurisé** : formulaire avec vérification CSRF, validation de l'extension, de la taille (max 5 Mo) et de la signature binaire du fichier
- **Onglet DISK** : spécifications générales du disque (format, créateur, nombre de pistes/faces, tailles déclarées/réelles, Sum DATA) et répartition des secteurs par taille
- **Onglet FILES** : catalogue CP/M — liste des fichiers avec nom, extension, numéro d'utilisateur, attributs (lecture seule, caché) et taille
- **Onglet MAP** : carte visuelle des secteurs par piste avec code couleur (normal, effacé, weak, incomplet) et barre de statistiques
- **Onglet SECTORS** : tableau exhaustif de chaque secteur (ID, taille déclarée/réelle, Sum DATA, flags FDC SR1/SR2, statuts Erased/Weak/Used)
- **Onglet TRACKS** : récapitulatif par piste (nombre de secteurs, taille totale, octets GAP et FILLER, Sum DATA)
- **Onglet INFOS** : documentation technique complète sur les protections (Weak Sectors, Erased Sectors, Size 6, GAPS), le format DSK, les flags FDC et la FAT CP/M
- **Nettoyage automatique** des fichiers uploadés après 1 heure

### Code couleur des secteurs (onglet MAP)

| Couleur | Signification |
|---|---|
| Blanc `#FFFFFF` | Secteur normal — utilisé |
| Gris `#A0A0A0` | Secteur normal — vide |
| Bleu clair `#84CFEF` | Secteur effacé (Erased) — utilisé |
| Bleu `#0073DF` | Secteur effacé (Erased) — vide |
| Rouge `#FF0000` | Secteur faible (Weak) — utilisé |
| Rouge foncé `#A00000` | Secteur faible (Weak) — vide |
| Magenta `#FF00FF` | Weak + Erased — utilisé |
| Magenta foncé `#BA00BA` | Weak + Erased — vide |
| Blanc + bordure verte pointillée | Secteur incomplet (realSize ≠ declSize) |

### Structure du projet

```
sector-view-v2/
├── index.php                        Point d'entrée unique (bootstrap + dispatch)
├── config/
│   └── app.php                      Constantes de configuration
├── src/
│   ├── Domain/
│   │   ├── DskParser.php            Lecture binaire du fichier .dsk
│   │   ├── CpmDirectoryParser.php   Parsing du catalogue CP/M
│   │   └── DiskStats.php            Calcul des métriques agrégées
│   ├── Service/
│   │   ├── CsrfService.php          Gestion du token CSRF
│   │   ├── FileCleanupService.php   Nettoyage des uploads expirés
│   │   └── UploadService.php        Validation et stockage du fichier
│   └── Helper/
│       └── FormatHelper.php         Fonctions utilitaires d'affichage
├── templates/
│   ├── layout.php                   Squelette HTML global
│   ├── upload.php                   Vue formulaire d'upload
│   ├── disk_banner.php              Bannière d'information disque
│   ├── partials/
│   │   └── error_msg.php            Composant message d'erreur
│   └── tabs/
│       ├── tab_disk.php             Onglet DISK
│       ├── tab_files.php            Onglet FILES
│       ├── tab_map.php              Onglet MAP
│       ├── tab_sectors.php          Onglet SECTORS
│       ├── tab_tracks.php           Onglet TRACKS
│       └── tab_infos.php            Onglet INFOS
├── public/
│   └── assets/
│       ├── style.css                Styles CSS
│       └── app.js                   JavaScript (onglets, drag-and-drop)
└── files/                           Stockage temporaire des uploads
```

### Architecture

L'application suit une **séparation stricte des responsabilités** sans framework :

- **Domain** : logique métier pure (parsing binaire, calcul de statistiques). Aucune dépendance vers les couches supérieures.
- **Service** : orchestration des opérations transverses (upload, sécurité, nettoyage).
- **Helper** : fonctions pures d'affichage réutilisables dans les templates.
- **Templates** : présentation uniquement. Aucune logique métier, uniquement de l'affichage conditionnel et des appels aux helpers.
- **`index.php`** : point d'entrée minimaliste qui orchestre les couches sans les mélanger.

### Prérequis

- PHP 7.4 ou supérieur
- Extension `fileinfo` activée
- Droits d'écriture sur le dossier `files/`
- Serveur web (Apache, Nginx, ou serveur de développement PHP)

### Installation

```bash
# Copier le dossier sector-view-v2/ dans la racine web
# Vérifier les permissions sur le dossier d'upload
chmod 755 files/

# Lancer avec le serveur intégré PHP (développement)
php -S localhost:8080 -t .
```

Ouvrir ensuite `http://localhost:8080` dans un navigateur.

### Format DSK supporté

- ✅ **Extended CPC DSK** (signature : `EXTENDED CPC DSK File`)
- ✅ **DSK standard MV-CPCEMU** (signature : `MV - CPCEMU`)
- ❌ Autres variantes DSK non supportées

### Déploiement avec Docker

Le projet inclut un `Dockerfile` et un `docker-compose.yml` prêts à l'emploi.

**Développement local :**
```bash
docker compose up --build
# Accès sur http://localhost:8080
```

**Production sur VPS :**
```bash
# Retirer le volume de code source dans docker-compose.yml (la ligne "- .:/var/www/html")
# puis builder et lancer en arrière-plan :
docker compose up --build -d
```

Les fichiers uploadés sont persistés dans un volume Docker nommé `dsk_uploads` — ils survivent aux redémarrages et rebuilds du conteneur.

---