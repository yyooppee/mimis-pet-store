<?php

include "components/db.php";

// Function to get all products
function getAllProducts($conn) {
    $query = "SELECT * FROM product";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        // Handle the error, for example, by printing the error message
        die("Error: " . mysqli_error($conn));
    }

    return $result;
}

// Function to get brand data for a product
function getBrandData($conn, $productId) {
    $brand_query = "SELECT prod_brand FROM product WHERE prod_id = $productId";
    $brand_result = mysqli_query($conn, $brand_query);

    if (!$brand_result) {
        // Handle the error, for example, by printing the error message
        die("Error: " . mysqli_error($conn));
    }

    return mysqli_fetch_assoc($brand_result);
}

// Get all products
$productResult = getAllProducts($conn);

?>

<html>
<head>
    <?php include "Style.php"; ?>
</head>
<body>
    <?php include "header.php"; ?>

    <!-- Display Product Details -->
    <div class="content">
        <div class="container">
            <h2>Product Details</h2>

            <!-- Search Box -->
            <form action="" method="post">
                <label for="search">Search Product:</label>
                <input type="text" id="search" name="search" placeholder="Type to search">
                <input type="submit" value="Search">
            </form>
            <br>

            <form action="" method="post">
                <table>
                    <tr>
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Product Description</th>
                        <th>Product Price</th>
                        <th>Brand</th>
                        <th>Action</th> <!-- New column for the "Request" button -->
                    </tr>
                    <?php
                    while ($row = mysqli_fetch_assoc($productResult)) {
                        $brand_data = getBrandData($conn, $row['prod_id']);
                        ?>
                        <tr>
                            <td><?php echo $row['prod_id']; ?></td>
                            <td class="editable" onclick="editCell('<?php echo $row['prod_id']; ?>', 'Prod_Name', '<?php echo $row['prod_name']; ?>')"><?php echo $row['prod_name']; ?></td>
                            <td class="editable" onclick="editCell('<?php echo $row['prod_id']; ?>', 'Prod_Desc', '<?php echo $row['prod_desc']; ?>')"><?php echo $row['prod_desc']; ?></td>
                            <td class="editable" onclick="editNumberCell('<?php echo $row['prod_id']; ?>', 'Prod_Price', '<?php echo $row['prod_price']; ?>')"><?php echo $row['prod_price']; ?></td>
                            <td><?php echo $brand_data['prod_brand']; ?></td>
                            <td><button onclick="requestProduct('<?php echo $row['prod_id']; ?>')">Request</button></td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            </form>
        </div>
    </div>

    <script>
        // JavaScript function to handle the "Request" button click
        function requestProduct(productId) {
            // You can implement your logic here to handle the product request
            alert("Product Requested: " + productId);
        }
    </script>
</body>
</html>
