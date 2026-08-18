<?php
$members = [
    [
        'name' => 'OYANDO, RHONEL R.',
        'role' => 'MEMBER',
        'age' => 'Age: 22',
        'address' => 'SV3 Poblacion Munt.city',
        'contact' => '☎ 09676767',
        'img' => 'images/oyando.jpg',
    ],
    [
        'name' => 'CABALHIN, JHON EARL L.',
        'role' => 'MEMBER',
        'age' => 'Age: 19',
        'address' => 'Tunasan, Muntinlupa City',
        'contact' => '☎ 09630492157',
        'img' => 'images/cabalhin.jpg',
    ],
    [
        'name' => 'ROTAO, ALLYSA JOI B.',
        'role' => 'LEADERNIM',
        'age' => 'Age: 22',
        'address' => '69 Kamagong St., Green Revolution, CAA, Las Piñas City',
        'contact' => '☎ 09194171882',
        'img' => 'images/rotao.jpg',
    ],
    [
        'name' => 'RODELAS, JOYCE B.',
        'role' => 'MEMBER',
        'age' => 'Age: 20',
        'address' => 'Sitio pagkakaisa, Sucat. Muntinlupa City',
        'contact' => '☎ 09062109291',
        'img' => 'images/rodelas.jpg',
    ],
    [
        'name' => 'RUBIANES, ERICH V.',
        'role' => 'MEMBER',
        'age' => 'Age: 20',
        'address' => 'Sitio Pagkakaisa sucat Munt. City',
        'contact' => '☎ 09497316168',
        'img' => 'images/rubianes.jpg',
    ],
    [
        'name' => 'QUIANE, AJ M.',
        'role' => 'MEMBER',
        'age' => 'Age: 20',
        'address' => 'Joaquin Alabang Muntinlupa City',
        'contact' => '☎ 09345678901',
        'img' => 'images/quiane.jpg',
    ],
    [
        'name' => 'FERRER, KARL JUSTIN R.',
        'role' => 'MEMBER',
        'age' => 'Age: 21',
        'address' => 'Pacita 2 Phase 1 San Pedro Laguna',
        'contact' => '☎ 09123456789',
        'img' => 'images/ferrer.jpg',
    ],
];
?>

<!doctype html>
<html lang="en">
<head>
  <head>
    <link rel="stylesheet" href="style.css">
     <script src="script.js" defer></script>
</head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BAKA GROUP 3 TO</title>

    
</head>
<body>
    <header>
        <div class="wrap">
            <h1>Team Portfolio</h1>
            <p class="lead">GROUP 3 INTEGRATIVE PROGRAMMING 3J.</p>

            <div style="margin-top: 12px; display: flex; gap: 8px; align-items: center;">
                <input id="search" placeholder="Search by name or role" style="flex: 1; padding: 0.5rem 0.75rem; border-radius: 8px; border: 1px solid rgba(0,0,0,0.08);">
                <button id="clear" class="btn" style="padding: 0.5rem 0.75rem; border-radius: 8px;">Clear</button>
            </div>
        </div>
    </header>

    <main class="wrap">
        <section id="grid" class="grid">
            <?php foreach ($members as $i => $m): ?>
                <article class="card" data-name="<?= htmlspecialchars(strtolower($m['name'])) ?>" data-role="<?= htmlspecialchars(strtolower($m['role'])) ?>">
                    <img class="avatar" src="<?= htmlspecialchars($m['img']) ?>" alt="<?= htmlspecialchars($m['name']) ?>">

                    <div class="meta">
                        <p class="name"><?= htmlspecialchars($m['name']) ?></p>
                        <p class="role"><?= htmlspecialchars($m['role']) ?></p>

                        <div class="info">
                            <p><?= htmlspecialchars($m['age'] ?? 'Age: N/A') ?></p>
                            <p>📍 <?= htmlspecialchars($m['address'] ?? 'Address: TBD') ?></p>
                            <p><?= htmlspecialchars($m['contact'] ?? 'Contact: N/A') ?></p>
                        </div>

                        <div class="actions">
                            <button class="btn view" data-index="<?= $i ?>">View</button>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </section>
    </main>

    <div id="modal" class="modal" aria-hidden="true">
        <div class="panel">
            <button class="close" id="close">✕</button>
            <div id="modalContent"></div>
        </div>
    </div>

    <script>
        const members = <?php echo json_encode($members, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;

        const search = document.getElementById('search');
        const clearBtn = document.getElementById('clear');
        const grid = document.getElementById('grid');
        const modal = document.getElementById('modal');
        const modalContent = document.getElementById('modalContent');
        const closeBtn = document.getElementById('close');

        function renderModal(index) {
            const member = members[index];

            modalContent.innerHTML = `
                <div style="display: flex; gap: 12px; align-items: center;">
                    <img src="${member.img}" style="width: 84px; height: 84px; border-radius: 10px; object-fit: cover; flex: 0 0 84px;">
                    <div>
                        <h2 style="margin: 0;">${member.name}</h2>
                        <div style="color: var(--muted); margin: 0.25rem 0;">${member.role}</div>
                        <div style="margin: 0.5rem 0; color: var(--muted);">
                            <p style="margin: 0.2rem 0;">${member.age || 'Age: N/A'}</p>
                            <p style="margin: 0.2rem 0;">📍 ${member.address || 'Address: TBD'}</p>
                            <p style="margin: 0.2rem 0;">${member.contact || 'Contact: N/A'}</p>
                        </div>
                    </div>
                </div>
            `;

            modal.classList.add('open');
            modal.setAttribute('aria-hidden', 'false');
        }

        function closeModal() {
            modal.classList.remove('open');
            modal.setAttribute('aria-hidden', 'true');
        }

        if (grid) {
            grid.addEventListener('click', (event) => {
                const button = event.target.closest('.view');

                if (button) {
                    renderModal(button.dataset.index);
                }
            });
        }

        if (closeBtn) {
            closeBtn.addEventListener('click', closeModal);
        }

        if (modal) {
            modal.addEventListener('click', (event) => {
                if (event.target === modal) {
                    closeModal();
                }
            });
        }

        function filterGrid(query) {
            query = query.trim().toLowerCase();

            document.querySelectorAll('#grid .card').forEach((card) => {
                const name = card.dataset.name || '';
                const role = card.dataset.role || '';
                const matches = !query || name.includes(query) || role.includes(query);

                card.style.display = matches ? '' : 'none';
            });
        }

        if (search) {
            search.addEventListener('input', (event) => filterGrid(event.target.value));
        }

        if (clearBtn) {
            clearBtn.addEventListener('click', () => {
                search.value = '';
                filterGrid('');
            });
        }
    </script>
</body>
</html>

