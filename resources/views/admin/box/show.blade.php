@extends('admin.layouts.index')

@section('content-header-title',$box->number)

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="col-md-6">
                <div class="visible-print text-center">
                    {{--                    {!! QrCode::size(400)->generate($number); !!}--}}
                    <img id="qr" src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(400)->generate($box->number)) !!} ">
                </div>
            </div>
        </div>
    </div>

    <script>
        const image = document.getElementById("qr");

        image.addEventListener("click", function () {
            // Создаем элемент для печати
            const printElement = document.createElement("img");
            printElement.src = image.getAttribute('src');

            const printWindow = window.open('', '', 'width=600,height=600');

            printWindow.document.body.appendChild(printElement);

            printWindow.print();

            // printWindow.close();
        });
    </script>
@endsection



