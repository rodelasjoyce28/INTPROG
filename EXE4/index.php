<?php

$search = isset($_POST['search']) ? trim($_POST['search']) : "";

$members = [
    [
        "name" => "OYANDO, RHONEL R.",
        "role" => "MEMBER",
        "age" => 22,
        "address" => "SV3 Poblacion, Muntinlupa City",
        "phone" => "09170000001",
        "image" => "oyando.jpg"
    ],
    [
        "name" => "CABALHIN, JHON EARL L.",
        "role" => "MEMBER",
        "age" => 19,
        "address" => "Tunasan, Muntinlupa City",
        "phone" => "09170000002",
        "image" => "cabalhin.jpg"
    ],
    [
        "name" => "ROTAO, ALLYSA JOI",
        "role" => "LEADER",
        "age" => 22,
        "address" => "Green Revolution, Las Piñas City",
        "phone" => "09170000003",
        "image" => "rotao.jpg"
    ],
    [
        "name" => "RODELAS, JOYCE B.",
        "role" => "MEMBER",
        "age" => 20,
        "address" => "Sucat, Muntinlupa City",
        "phone" => "09170000004",
        "image" => "rodelas.jpg"
    ],
    [
        "name" => "RUBIANES, ERICH V.",
        "role" => "MEMBER",
        "age" => 20,
        "address" => "Sucat, Muntinlupa City",
        "phone" => "09170000005",
        "image" => "rubianes.jpg"
    ],
    [
        "name" => "QUIANE, AJ M.",
        "role" => "MEMBER",
        "age" => 20,
        "address" => "Alabang, Muntinlupa City",
        "phone" => "09170000006",
        "image" => "quiane.jpg"
    ],
    [
        "name" => "FERRER, KARL JUSTIN R.",
        "role" => "MEMBER",
        "age" => 21,
        "address" => "San Pedro, Laguna",
        "phone" => "09170000007",
        "image" => "ferrer.jpg"
    ]
];

$filteredMembers = [];

foreach ($members as $member) {
    if (
        $search === "" ||
        stripos($member["name"], $search) !== false ||
        stripos($member["role"], $search) !== false
    ) {
        $filteredMembers[] = $member;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Team Portfolio</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

    <header class="header">

        <div class="container">

            <h1 class="title">
                Team Portfolio
            </h1>

            <div class="subtitle">
                GROUP 3 INTEGRATIVE PROGRAMMING 3J.
            </div>

            <form
                action="index.php"
                method="POST"
                class="search-form"
            >

                <input
                    type="text"
                    name="search"
                    class="search-input"
                    placeholder="Search by name or role"
                    value="<?php echo htmlspecialchars($search); ?>"
                >

                <button
                    type="submit"
                    class="search-btn"
                >
                    Search
                </button>

                <a
                    href="index.php"
                    class="clear-btn"
                >
                    Clear
                </a>

            </form>

        </div>

    </header>

    <main class="container team-container">

        <div class="team-grid">

            <?php if (count($filteredMembers) > 0): ?>

                <?php foreach ($filteredMembers as $member): ?>

                    <div class="member-card">

                        <img
                            src="<?php echo htmlspecialchars($member["image"]); ?>"
                            alt="Profile Picture"
                            class="profile-image"
                        >

                        <div class="member-info">

                            <h2 class="member-name">
                                <?php echo htmlspecialchars($member["name"]); ?>
                            </h2>

                            <div class="member-role">
                                <?php echo htmlspecialchars($member["role"]); ?>
                            </div>

                            <div class="member-detail">
                                🎂 Age:
                                <?php echo htmlspecialchars($member["age"]); ?>
                            </div>

                            <div class="member-detail">
                                📍
                                <?php echo htmlspecialchars($member["address"]); ?>
                            </div>

                            <div class="member-detail">
                                ☎
                                <?php echo htmlspecialchars($member["phone"]); ?>
                            </div>

                            <a
                                href="#"
                                class="view-btn"
                            >
                                View
                            </a>

                        </div>

                    </div>

                <?php endforeach; ?>

            <?php else: ?>

                <div class="no-results">
                    No team member found.
                </div>

            <?php endif; ?>

        </div>

    </main>

</body>

</html>