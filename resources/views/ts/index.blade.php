<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- @vite('resources/css/app.css') -->
   <!-- <style link= {{ asset('build/assets/app-CxNfFamx.css') }}></style> -->
   <link rel="stylesheet" type="text/css" href= {{ asset('public/build/assets/app-CxNfFamx.css') }} >
    <script>
        function print(id)
        {
            let url = `print/${id}`;
            window.open(url);
        }

        function excel(id)
        {
            let url = `excel/${id}`;
            window.open(url);
        }
    </script>
</head>
<body>
    <div class="container mx-auto">
        <div class="relative overflow-x-auto">
            <table class=" text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            STUB NO
                        </th>
                        <th scope="col" class="px-6 py-3">
                           START
                        </th>
                        <th scope="col" class="px-6 py-3">
                            END
                        </th>
                        <th scope="col" class="px-6 py-3">
                            
                        </th>
                        <th scope="col" class="px-6 py-3">
                            
                            </th>
                    </tr>
                </thead>
                <tbody>
                   @foreach($stubs as $stub)

                       <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                           <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                               {{ $stub->stub_no }}
                           </th>
                           <td class="px-6 py-4">
                               {{ $stub->doc_from }}
                           </td>
                           <td class="px-6 py-4">
                               {{ $stub->doc_to }}
                           </td>
                           <td class="px-6 py-4">
                               <button type="button" onclick="print({{ $stub->doc_id }})" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">PDF</button>
                           </td>
                           <td class="px-6 py-4">
                               <button type="button" onclick="excel({{ $stub->doc_id }})" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">EXCEL</button>
                           </td>
                       </tr>
                   @endforeach
                <!--
                   <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                       <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                           Apple MacBook Pro 17"
                       </th>
                       <td class="px-6 py-4">
                           Silver
                       </td>
                       <td class="px-6 py-4">
                           Laptop
                       </td>
                       <td class="px-6 py-4">
                           $2999
                       </td>
                   </tr>
                  <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                       <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                           Microsoft Surface Pro
                       </th>
                       <td class="px-6 py-4">
                           White
                       </td>
                       <td class="px-6 py-4">
                           Laptop PC
                       </td>
                       <td class="px-6 py-4">
                           $1999
                       </td>
                   </tr>
                   <tr class="bg-white dark:bg-gray-800">
                       <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                           Magic Mouse 2
                       </th>
                       <td class="px-6 py-4">
                           Black
                       </td>
                       <td class="px-6 py-4">
                           Accessories
                       </td>
                       <td class="px-6 py-4">
                           $99
                       </td>
                   </tr> -->
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
