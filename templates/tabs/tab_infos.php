    <div id="tab-infos" class="tab-panel">

        <!-- Légende visuelle des couleurs -->
        <div class="info-section" style="border-left-color:#FF0000">
            <h3><span class="info-swatch" style="background:#FF0000"></span> WEAK SECTORS</h3>
            <div class="info-color-row">
                <span class="info-swatch-block" style="background:#FF0000;color:#fff">Weak</span>
                <span class="info-swatch-block" style="background:#A00000;color:#fff">Weak vide</span>
            </div>
            <p>Secteurs faibles. Leur lecture retournera des données différentes à chaque fois. Il faut savoir qu'un secteur faible peut être aussi présent sur les autres tailles de secteur mais dans ce cas là, il sera stocké 2 ou 3 fois suivant le logiciel de dump.</p>
            <p style="margin-top:8px"><strong>ATTENTION :</strong> Un secteur défectueux sera considéré comme Weak Sectors et n'aura rien à voir avec ce système de protection.</p>
        </div>

        <div class="info-section" style="border-left-color:#84CFEF">
            <h3><span class="info-swatch" style="background:#84CFEF"></span> ERASED SECTORS</h3>
            <div class="info-color-row">
                <span class="info-swatch-block" style="background:#84CFEF">Erased utilisé</span>
                <span class="info-swatch-block" style="background:#0073DF;color:#fff">Erased vide</span>
            </div>
            <p>Secteurs ayant l'attribut effacé (Control Mark — bit 6 de FDC SR2 = 1, ex: <code>0100 0000</code>). Les données sont tout de même possibles à lire.</p>
        </div>

        <div class="info-section" style="border-left-color:#FF00FF">
            <h3><span class="info-swatch" style="background:#FF00FF"></span> ERASED + WEAK SECTOR</h3>
            <div class="info-color-row">
                <span class="info-swatch-block" style="background:#FF00FF;color:#fff">Weak+Erased utilisé</span>
                <span class="info-swatch-block" style="background:#BA00BA;color:#fff">Weak+Erased vide</span>
            </div>
            <p>Secteurs qui cumulent à la fois l'attribut effacé et l'attribut faible (weak).</p>
        </div>

        <div class="info-section" style="border-left-color:var(--orange)">
            <h3>INCOMPLETE SECTOR</h3>
            <div class="info-color-row">
                <span class="info-swatch-block" style="background:#fff;color:#333;border:2px dashed green">Incomplete</span>
            </div>
            <p>Secteurs dont la taille réelle est inférieure à la taille déclarée. On retrouve souvent cette information sur les secteurs de taille 6 (8192 octets) qui contiennent de 6144 à 6304 octets de données valides. Sur les secteurs de taille 7 (16384 octets) ou 8 (32768 octets) avec des données pouvant aller de 0 à 8192 octets, souvent utilisé comme système de protection.</p>
        </div>

        <div class="info-section" style="border-left-color:var(--orange)">
            <h3>PROTECTION SECTEUR SIZE 6</h3>
            <p><strong>À partir d'un CPC :</strong> Sur une disquette on peut rentrer normalement 6250 octets par piste. En pratique c'est un petit peu plus sur une 3 pouces, mais on reste loin des 8192 octets (8 Ko) d'un secteur de taille 6. Normalement, ces secteurs sont utilisés pour effacer complètement une piste : trop longs, la fin du secteur écrase le début et on se retrouve avec une piste sans secteur du tout, impossible à lire avec le FDC du CPC (mais lisible sur un Atari ST).</p>
            <p style="margin-top:8px">La solution pour copier ce genre de disquette : lancer la copie du secteur puis, juste avant que la disquette ait fait un tour complet, arrêter le moteur. Ainsi la fin du secteur n'est pas écrite et on préserve le début. Un duplicateur industriel n'a pas ce problème.</p>
            <p style="margin-top:8px"><strong>Traceuse industrielle :</strong> Avec un outil de mastering tel qu'une traceuse industrielle, il est possible de créer n'importe quel type de secteur (taille 6, 7, 8...) dans les limites du contrôleur FDC upd765. Le FDC upd765 est une puce très puissante dont l'emploi sur l'Amstrad CPC a été restreinte (8 bits seulement). Une traceuse écrit en aveugle sur le support physique, sans s'occuper des flags et autres signaux de marquage.</p>
        </div>

        <div class="info-section" style="border-left-color:var(--text-dim)">
            <h3>FDC ERRORS</h3>
            <p>Le principal problème est que le FDC retournera toujours une erreur sur la lecture d'un secteur de taille 6 : impossible de savoir si c'est normal ou s'il y a un problème sur la lecture du début du secteur (la partie utile). L'information est accessible via le FDC Flag 2, lorsque le bit 6 est à 1, exemple : <code>0100 0000</code></p>
        </div>

        <div class="info-section" style="border-left-color:var(--accent2)">
            <h3>PROTECTION GAPS</h3>
            <p>Protection utilisée par quelques éditeurs (Loriciels, Microid, Infogrames, UBI Soft, Cobra Soft, Broderburn…) permettant de lire des informations présentes entre deux secteurs, et entre l'en-tête d'un secteur et ses données. L'Amstrad CPC ne peut que lire les informations GAPS mais ne peut en aucun cas les écrire.</p>
        </div>

        <div class="info-section" style="border-left-color:var(--accent)">
            <h3>FDC FLAGS — Lecture des bits (de droite à gauche : 76543210)</h3>
            <div class="fdc-grid">
                <div class="fdc-col">
                    <div class="fdc-title">Status Register 1</div>
                    <table class="fdc-table">
                        <tr><td>bit 0</td><td><strong>MA</strong></td><td>Missing Address Mark (Sector_ID ou DAM non trouvé)</td></tr>
                        <tr><td>bit 1</td><td><strong>NW</strong></td><td>Not Writeable (écriture/format avec wprot)</td></tr>
                        <tr><td>bit 2</td><td><strong>ND</strong></td><td>No Data (Sector_ID non trouvé, CRC fail ID_field)</td></tr>
                        <tr><td>bit 3</td><td>—</td><td>Non utilisé</td></tr>
                        <tr><td>bit 4</td><td><strong>OR</strong></td><td>Over Run (CPU trop lent ~26µs/octet)</td></tr>
                        <tr><td>bit 5</td><td><strong>DE</strong></td><td>Data Error (CRC-fail ID ou Data-Field) → <span style="color:var(--red)">WEAK</span></td></tr>
                        <tr><td>bit 6</td><td>—</td><td>Non utilisé</td></tr>
                        <tr><td>bit 7</td><td><strong>EN</strong></td><td>End of Track</td></tr>
                    </table>
                </div>
                <div class="fdc-col">
                    <div class="fdc-title">Status Register 2</div>
                    <table class="fdc-table">
                        <tr><td>bit 0</td><td><strong>MD</strong></td><td>Missing Address Mark in Data Field</td></tr>
                        <tr><td>bit 1</td><td><strong>BC</strong></td><td>Bad Cylinder (track-ID lu = FF)</td></tr>
                        <tr><td>bit 2</td><td><strong>SN</strong></td><td>Scan Not Satisfied</td></tr>
                        <tr><td>bit 3</td><td><strong>SH</strong></td><td>Scan Equal Hit</td></tr>
                        <tr><td>bit 4</td><td><strong>WC</strong></td><td>Wrong Cylinder (track-ID différent)</td></tr>
                        <tr><td>bit 5</td><td><strong>DD</strong></td><td>Data Error in Data Field → <span style="color:var(--red)">WEAK</span></td></tr>
                        <tr><td>bit 6</td><td><strong>CM</strong></td><td>Control Mark (DAM effacé) → <span style="color:#84CFEF">ERASED</span></td></tr>
                        <tr><td>bit 7</td><td>—</td><td>Non utilisé</td></tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="info-section" style="border-left-color:var(--green)">
            <h3>FAT — Table d'allocation des fichiers</h3>
            <p>Comprend en principe au maximum 64 entrées, réparties sur 4 secteurs de taille 2 (512 × 4 = 2 Ko). Chaque entrée permet de stocker les informations jusqu'à 16 Ko de données. Les entrées sont écrites sur 32 octets.</p>
            <p style="margin-top:8px">Les FAT peuvent être présentes par défaut en :</p>
            <ul>
                <li>Piste 0, secteurs &amp;C1 à &amp;C4 → Format DATA</li>
                <li>Piste 1, secteurs &amp;01 à &amp;04 → Format IBM</li>
                <li>Piste 2, secteurs &amp;41 à &amp;44 → Formats VENDOR ou SYSTEM</li>
            </ul>
            <p style="margin-top:8px">L'USER 229 (&amp;E5) correspond à l'emplacement des fichiers effacés.</p>
        </div>

        <div class="info-section" style="border-left-color:var(--text-dim)">
            <h3>SUM DATA</h3>
            <p>Option permettant de comparer rapidement deux dumps pour trouver des différences. Pour les secteurs de taille 6, la somme est limitée aux 6144 premiers octets (&amp;1800) — valeur minimum commune aux différents secteurs de taille 6 ayant 6 Ko de données (un secteur de taille 6 ne peut être plein).</p>
        </div>
    </div>

