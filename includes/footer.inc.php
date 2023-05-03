   <script src="./assets/js/bootstrap.bundle.min.js"></script>
   <script src="./assets/js/jquery.js"></script>
   <script src="./assets/js/datatables.min.js"></script>
   <script src="./assets/js/dataTables.checkboxes.min.js"></script>
   <script src="./assets/js/sweetalert2.all.min.js"></script>

   <script type="text/javascript">
       let table = new DataTable('#myTable', {
           columnDefs: [{
               'targets': [0],
               'checkboxes': {
                   'selectRow': false,
                   selectAllPages: false
               }
           }],
       });
   </script>
   </body>

   </html>