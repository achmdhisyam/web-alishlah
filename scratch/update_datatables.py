import re

file_path = r"c:\xampp2\htdocs\websitesekolah-main\app\Views\admin\layout\footer.php"
with open(file_path, "r", encoding="utf-8") as f:
    content = f.read()

# Replace the DataTables JS initialization
pattern = r"\$\(function \(\) \{\n\s*\$\(\"#example1\"\)\.DataTable\(\{.*?\n\s*\}\);\n\s*\}\);"

replacement = """  $(function () {
    var exportConfig = [
        { extend: 'copy', exportOptions: { columns: ':not(:last-child)' } },
        { extend: 'csv', exportOptions: { columns: ':not(:last-child)' } },
        { extend: 'excel', exportOptions: { columns: ':not(:last-child)' } },
        { extend: 'pdf', exportOptions: { columns: ':not(:last-child)' } },
        { extend: 'print', exportOptions: { columns: ':not(:last-child)' } },
        "colvis"
      ];
      
    var exportConfig2 = [
        { extend: 'copy', exportOptions: { columns: ':not(:first-child):not(:last-child)' } },
        { extend: 'csv', exportOptions: { columns: ':not(:first-child):not(:last-child)' } },
        { extend: 'excel', exportOptions: { columns: ':not(:first-child):not(:last-child)' } },
        { extend: 'pdf', exportOptions: { columns: ':not(:first-child):not(:last-child)' } },
        { extend: 'print', exportOptions: { columns: ':not(:first-child):not(:last-child)' } },
        "colvis"
      ];

    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": exportConfig
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
      "buttons": exportConfig2
    }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
    
    $('#example3').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
      "buttons": exportConfig
    }).buttons().container().appendTo('#example3_wrapper .col-md-6:eq(0)');
  });"""

content = re.sub(pattern, replacement, content, flags=re.DOTALL)

with open(file_path, "w", encoding="utf-8") as f:
    f.write(content)

print("footer.php DataTables updated.")
