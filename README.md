**Comic Sales Graph**

This WordPress template generates a bar chart comparing comic book sales for two aquatic superheroes—Aquaman and Namor—over several years. It provides a visual representation of sales data, making it easier to analyze and compare the performance of these characters.

**Features**

The template offers data visualization by displaying a bar chart. It utilizes a CSV file as the data source, containing monthly sales figures for both Aquaman and Namor. For rendering the chart, it employs Chart.js, a popular JavaScript library for creating interactive charts.

**How It Works**

The HTML structure of the template includes a container that holds a header and placeholder text. It also features a **`<canvas>`** element where the chart will be rendered.

The PHP script reads and parses a CSV file located in the theme directory. It processes the sales data, aggregating annual sales figures for Aquaman and Namor. This aggregated data is then prepared for use with Chart.js.

In the JavaScript section, a Chart.js bar chart is initialized with the aggregated sales data. The script configures various chart options, including appearance and interactive elements, to enhance the user experience.

**Setup**

To use this template, place the file in your WordPress theme directory. Ensure that the CSV file named **`aquaman_namor_monthly_sales.csv`** is also located in the same directory. The chart will automatically render on the page where this template is applied.

**Dependencies**

WordPress
Chart.js
