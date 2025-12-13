
<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="./output.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
         <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    </head>
    <body>
        <div class="flex justify-center gap-[30px] mt-[50px] mb-[70px]">
            <div class="relative">
                <div class="sticky top-[144px] flex flex-col w-[357px] shrink-0 h-fit rounded-[30px] ring-1 ring-tedja-border p-[10px] pb-5 gap-3 bg-white">
                    <div class="thumbnail-container relative w-full h-[240px] rounded-[30px] overflow-hidden">
                        <img src="{{ url('storage/' . $room->image) }}" class="w-full h-full object-cover" alt="thumbnail">
                    </div>
                    <div class="flex flex-col gap-[18px] px-[10px]">
                        <div class="flex flex-col gap-[6px]">
                            <h3 class="font-bold text-lg">{{ $room->name }}</h3>
                            <div class="flex items-center gap-[6px]">
                                <p class="font-semibold text-sm">{{ $duration }}  Bulan</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="flex flex-col gap-5 w-[500px] shrink-0">
                <form action="{{ route('booking') }}" id="Request-Mortage" class="border border-[#F2F2F4] bg-white !h-fit w-full p-5 rounded-[20px] flex flex-col gap-5" method="post">
                    @csrf
                    <input type="hidden" name="room_id" value="{{ $room->id }}">
                    <input type="hidden" name="duration" value="{{ $duration }}">
                    <div class="flex flex-col gap-2">
                        <p class="font-semibold">Tanggal masuk</p>
                        <label id="Input-File-Trigger" type="button" class="relative flex items-center rounded-full border border-tedja-black py-[14px] px-5 gap-[10px]">
                            <input type="date" name="date_in" id="File-Input" class="">
                        </label>
                    </div>
                    <div class="flex flex-col gap-2">
                        <p class="font-semibold">Tanggal keluar</p>
                        <label id="Input-File-Trigger" type="button" class="relative flex items-center rounded-full border border-tedja-black py-[14px] px-5 gap-[10px]">
                            <input type="date" name="date_out" id="File-Input" class="">
                        </label>
                    </div>
                    <button type="submit" class="rounded-full py-[14px] px-5 bg-green-500 w-full text-center font-semibold">Booking Now</button>
                </form>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script src="js/accordion.js"></script>
        <script src="js/navbar-dropdown.js"></script>
        <script src="js/file-input.js"></script>
        <script src="js/request-mortage.js"></script>

    </body>
</html>
