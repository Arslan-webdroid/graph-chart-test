<?php 
/* Template Name: Comic Sales Graph */
get_header();
?>
<style>
.container{
    width: 1200px !important;
    padding: 20px;
    width: 100%;
}

</style>
<div class="container">
<div class ="innerwrap">
    <h1>a comparison of comic book sales between two aquatic
    superheroes (Aquaman and Namor) over the past several years.</h1>
    <p>
    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur congue
tincidunt vehicula. In hac habitasse platea dictumst. Maecenas et nisl elit.
Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere
cubilia curae; Suspendisse viverra eu lacus vitae imperdiet. Morbi non
rutrum urna, non euismod lorem. Proin at dolor at magna lacinia tincidunt.
Pellentesque auctor leo nisi, non suscipit arcu molestie ut. Maecenas
pellentesque turpis ut purus maximus, finibus placerat turpis tristique.
    </p>
</div>

<canvas id="comicsaleschart" width="400" height="200"></canvas>
    <?php
    // Path to the CSV file
    $csvFilePath = get_template_directory() . '/aquaman_namor_monthly_sales.csv';

    // Read and parse the CSV file
    if (file_exists($csvFilePath)) {
        $data = array_map('str_getcsv', file($csvFilePath));
        $header = array_shift($data);

        // Ensure headers are mapped correctly
        $yearIndex = array_search('Year', $header);
        $aquamanIndex = array_search('aquaman_comics_monthly_sales', $header);
        $namorIndex = array_search('namor_comics_monthly_sales', $header);

        // Initialize annual sales array
        $annual_sales = [];
        
        foreach ($data as $row) {
            if (count($row) <= max($yearIndex, $aquamanIndex, $namorIndex)) {
                continue; // Skip rows with insufficient data
            }

            $year = $row[$yearIndex];
            $aquaman = (float)$row[$aquamanIndex];
            $namor = (float)$row[$namorIndex];

            if (!isset($annual_sales[$year])) {
                $annual_sales[$year] = ['aquaman' => 0, 'namor' => 0];
            }

            $annual_sales[$year]['aquaman'] += $aquaman;
            $annual_sales[$year]['namor'] += $namor;
        }

        // Prepare data for Chart.js
        $labels = array_keys($annual_sales);
        $aquaman_sales = array_column($annual_sales, 'aquaman');
        $namor_sales = array_column($annual_sales, 'namor');
    } else {
        echo "CSV file not found.";
        $labels = [];
        $aquaman_sales = [];
        $namor_sales = [];
    }
    ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('comicsaleschart').getContext('2d');
            const chartData = {
                labels: <?php echo json_encode($labels); ?>,
                datasets: [
                    {
                        label: 'Aquaman Sales',
                        data: <?php echo json_encode($aquaman_sales); ?>,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Namor Sales',
                        data: <?php echo json_encode($namor_sales); ?>,
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1
                    }
                ]
            };

            new Chart(ctx, {
                type: 'bar', // Change to 'line', 'pie', etc., if needed
                data: chartData,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true,
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': $' + context.raw.toLocaleString();
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>

</div>

<?php get_footer(); ?>