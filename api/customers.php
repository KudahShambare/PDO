




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Records</title>


</head>

<?php

// cONNECT tO db

//rETRIEVE rECORDS



?>


     <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($customers as $customer): ?>
                    <tr>
                        <td><?= htmlspecialchars((string) $customer['id']) ?></td>
                        <td><?= htmlspecialchars($customer['name']) ?></td>
                        <td>
                            <a href="mailto:<?= htmlspecialchars($customer['email']) ?>">
                                <?= htmlspecialchars($customer['email']) ?>
                            </a>
                        </td>
                        <td><?= htmlspecialchars($customer['created_at']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>


</html>







