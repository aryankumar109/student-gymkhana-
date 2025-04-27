<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Club Proposal Form</title>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <!-- Removed inline style block -->
</head>
<body>
    <div class="container mt-5 mb-5"> <!-- Added top/bottom margin -->
         <div class="card shadow">
             <div class="card-header bg-info text-white"> <!-- Info header -->
                 <h2 class="mb-0">Club Proposal Form</h2> <!-- Removed extra margin -->
             </div>
             <div class="card-body">
                 <form id="proposalForm" method="post" action="includes/data.php"> <!-- Corrected action path -->
                    <!-- Removed enctype as it's not needed unless uploading files -->

                    <div class="form-group">
                        <label for="club">Select Club:</label>
                        <select id="club" name="club" class="form-control">
                            <option value="ArtGeeks">ArtGeeks</option>
                            <option value="SAE">SAE</option>
                            <option value="HnT">Hiking & Trekking</option>
                            <option value="Yantrik">Yantrik</option>
                            <option value="Robotronics">Robotronics</option>
                            <option value="MTB">Mountain Biking Club</option>
                            <option value="GDSC">GDSC</option>
                            <option value="Stac">STAC</option>
                            <option value="PMC">Photography & Movie Making</option>
                            <option value="Designauts">Designauts</option>
                            <option value="Kamandprompt">Kamandprompt</option>
                            <option value="Nirmaan">Nirmaan</option>
                             <!-- Add other clubs -->
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="idea">Idea/Proposal Description:</label>
                        <textarea id="idea" name="idea" class="form-control" rows="5" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="budget">Estimated Budget (INR):</label>
                         <input type="number" id="budget" name="budget" class="form-control" required min="0" step="0.01">
                        <!-- Changed budget to number input -->
                    </div>

                    <hr> <!-- Separator -->
                    <h4 class="mb-3">Item Breakdown</h4>

                    <div class="form-group">
                       <!-- <label>Items:</label> --> <!-- Label might be redundant with table header -->
                        <table class="table table-bordered table-sm"> <!-- Bootstrap table styling -->
                            <thead>
                                <tr>
                                    <th style="width: 10%;">#</th>
                                    <th>Item Name</th>
                                    <th style="width: 20%;">Quantity</th>
                                    <th style="width: 10%;">Action</th>
                                </tr>
                            </thead>
                            <tbody id="items-tbody">
                                <tr>
                                    <td>1</td>
                                    <td><input type="text" name="itemName[]" class="form-control form-control-sm" required></td>
                                    <td><input type="number" name="itemquantity[]" class="form-control form-control-sm" min="1" step="1" required></td>
                                    <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">X</button></td>
                                </tr>
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-secondary btn-sm" onclick="addRow()">+ Add Item</button>
                    </div>

                    <hr> <!-- Separator -->

                     <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="fromEmail">Your Email (Submitter):</label>
                            <input type="email" id="fromEmail" name="fromEmail" class="form-control" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="toEmail">Recipient's Email (e.g., Faculty Advisor):</label>
                            <input type="email" id="toEmail" name="toEmail" class="form-control" required>
                        </div>
                    </div>

                     <!-- Removed the specific "Submit for Club FA Approval" button for now -->
                    <!-- <div class="form-group">
                        <input type="button" class="btn btn-warning" value="Submit for Club FA Approval" onclick="submitToApprovalPage()">
                    </div> -->

                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-primary btn-lg w-100">Submit Proposal Data</button>
                        <!-- Changed button type to submit -->
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let rowCount = 1;

        function addRow() {
            rowCount++;
            const tbody = document.getElementById('items-tbody');
            const newRow = tbody.insertRow();
            newRow.innerHTML = `
                <td>${rowCount}</td>
                <td><input type="text" name="itemName[]" class="form-control form-control-sm" required></td>
                <td><input type="number" name="itemquantity[]" class="form-control form-control-sm" min="1" step="1" required></td>
                <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">X</button></td>
            `;
            updateRowNumbers();
        }

        function removeRow(button) {
            const row = button.closest('tr');
            row.remove();
            updateRowNumbers();
             // Ensure at least one row remains if needed (optional)
             const tbody = document.getElementById('items-tbody');
             if (tbody.rows.length === 0) {
                 rowCount = 0; // Reset count if all rows removed
                 addRow(); // Add a blank row back
             }
        }

        function updateRowNumbers() {
            const tbody = document.getElementById('items-tbody');
            const rows = tbody.getElementsByTagName('tr');
            for (let i = 0; i < rows.length; i++) {
                rows[i].cells[0].innerText = i + 1;
            }
            rowCount = rows.length; // Update global row count
        }

        // Removed submitToApprovalPage() as the button is commented out
    </script>
</body>
</html>