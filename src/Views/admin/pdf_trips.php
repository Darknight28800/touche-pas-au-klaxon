<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Export des trajets</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        /* HEADER */
        .header {
            text-align: center;
            padding: 15px 0;
            border-bottom: 2px solid #444;
        }

        .header h1 {
            margin: 0;
            font-size: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* FOOTER */
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            color: #555;
            border-top: 1px solid #aaa;
            padding: 5px 0;
        }

        /* TABLE */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }

        th {
            background: #f2f2f2;
            border: 1px solid #444;
            padding: 6px;
            font-weight: bold;
            text-align: left;
        }

        td {
            border: 1px solid #444;
            padding: 6px;
        }

        tr:nth-child(even) {
            background: #fafafa;
        }

        .stats {
            margin-top: 15px;
            font-size: 12px;
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <?php 
        // Mets ici ton logo en base64 si tu veux l'afficher
        $logo = ''; 
    ?>

    <div class="header">
        <?php if ($logo): ?>
            <img src="<?= $logo ?>" alt="Logo" style="width: 120px; margin-bottom: 10px;">
        <?php endif; ?>

        <h1>Liste des trajets</h1>
        <div style="font-size: 11px; color: #555;">
            Export généré le <?= date('d/m/Y à H:i') ?>
        </div>
    </div>


    <!-- STATISTIQUES -->
    <div class="stats">
        <strong>Statistiques :</strong><br>
        - Total trajets : <?= $totalAll ?><br>
        - Trajets correspondant aux filtres : <?= $totalFiltered ?><br>

        <?php if (!empty($filters['departure'])): ?>
            - Agence départ :
            <?= htmlspecialchars($agencies[array_search($filters['departure'], array_column($agencies, 'id'))]['name']) ?><br>
        <?php endif; ?>

        <?php if (!empty($filters['arrival'])): ?>
            - Agence arrivée :
            <?= htmlspecialchars($agencies[array_search($filters['arrival'], array_column($agencies, 'id'))]['name']) ?><br>
        <?php endif; ?>

        <?php if (!empty($filters['driver'])): ?>
            - Conducteur :
            <?php 
                $u = $users[array_search($filters['driver'], array_column($users, 'id'))];
                echo htmlspecialchars($u['firstname'] . ' ' . $u['lastname']);
            ?><br>
        <?php endif; ?>

        <?php if (!empty($filters['date'])): ?>
            - Date de départ : <?= htmlspecialchars($filters['date']) ?><br>
        <?php endif; ?>
    </div>


    <!-- TABLEAU -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Départ</th>
                <th>Arrivée</th>
                <th>Date départ</th>
                <th>Conducteur</th>
                <th>Places totales</th>
                <th>Places dispo</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($trips as $trip): ?>
                <tr>
                    <td><?= intval($trip['id']) ?></td>
                    <td><?= htmlspecialchars($trip['departure_agency_name']) ?></td>
                    <td><?= htmlspecialchars($trip['arrival_agency_name']) ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($trip['departure_datetime'])) ?></td>
                    <td><?= htmlspecialchars($trip['driver_firstname'] . ' ' . $trip['driver_lastname']) ?></td>
                    <td><?= intval($trip['seats_total']) ?></td>
                    <td><?= intval($trip['seats_available']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>


    <!-- FOOTER -->
    <div class="footer">
        Page <span class="pageNumber"></span> / <span class="totalPages"></span>
    </div>

</body>
</html>
