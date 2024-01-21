<?php
// Include your database connection file
include('db-connect.php');

// Validate and sanitize the page parameter
$page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
    'options' => array(
        'min_range' => 1,
    ),
));

if ($page === false || $page === null) {
    // Invalid page parameter, return an empty array
    echo json_encode(array());
    exit;
}

// Set the limit for quotes per page
$limit = 20;

// Calculate the offset based on the page and limit
$offset = ($page - 1) * $limit;

// Prepare and execute the database query
$query = "SELECT quotes.quote_text, authors.author_name
    FROM quotes
    JOIN authors ON quotes.author_id = authors.author_id
    LIMIT :per_page
    OFFSET :offset";

$stmt = $pdo->prepare($query);
$stmt->bindParam(':per_page', $limit, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();

// Fetch quotes from the database
$quotes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Close the database connection
$pdo = null;

// Function to generate HTML for a Bootstrap 5 Card
function generateCard($quote, $author)
{
    return '<div class="card mb-3 a4card w-100">
                <div class="card-header">' . htmlspecialchars($author) . '</div>
                <div class="card-body d-flex align-items-center">
                    <p class="card-text w-100">' . htmlspecialchars($quote) . '</p>
                </div>
            </div>';
}

// Generate HTML strings for each quote
$htmlArray = array_map(function ($quote) {
    return generateCard($quote['quote_text'], $quote['author_name']);
}, $quotes);

// Output the JSON-encoded array of HTML strings
echo json_encode($htmlArray);

?>