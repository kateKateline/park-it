<section id="message" class="bg-white py-24 relative overflow-hidden">
    {{-- Decorative Background Elements --}}
    <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/2 w-96 h-96 bg-slate-50 rounded-full blur-3xl opacity-50"></div>
    <div class="absolute bottom-0 left-0 translate-y-1/2 -translate-x-1/2 w-64 h-64 bg-slate-50 rounded-full blur-3xl opacity-50"></div>

    <div class="mx-auto max-w-7xl px-6 relative">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div data-aos="fade-right">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-100 border border-slate-200 mb-6">
                    <span class="w-2 h-2 rounded-full bg-slate-900 animate-pulse"></span>
                    <span class="text-[10px] font-bold uppercase tracking-widest text-slate-900">Hubungi Kami</span>
                </div>
                <h2 class="text-3xl lg:text-4xl font-bold tracking-tight text-slate-900 leading-tight">
                    Punya pertanyaan? <br/>
                    <span class="text-slate-900">Kami siap membantu Anda.</span>
                </h2>
                <p class="mt-6 text-slate-500 leading-relaxed max-w-md">
                    Silakan kirimkan pesan Anda melalui formulir ini. Tim kami akan segera merespons pertanyaan atau masukan Anda terkait layanan PARK-IT.
                </p>

                <div class="mt-10 space-y-6">
                    <div class="flex items-center gap-4 group">
                        <div class="flex h-12 w-12 items-center justify-center border border-slate-200 bg-white text-slate-900 group-hover:bg-slate-900 group-hover:text-white transition-colors duration-300">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <div class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Email</div>
                            <div class="text-slate-900 font-medium">rizkyramadhan12098@gmail.com</div>
                        </div>
                    </div>
                </div>
            </div>

            <div data-aos="fade-left" data-aos-delay="200">
                <div class="bg-white border border-slate-200 p-8 lg:p-10 shadow-sm relative">
                    <form action="mailto:rizkyramadhan12098@gmail.com" method="GET" enctype="text/plain" class="space-y-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label for="name" class="text-[10px] font-bold uppercase tracking-widest text-slate-900">Nama Lengkap</label>
                                <input type="text" name="subject" id="name" required
                                    class="w-full px-4 py-3 border border-slate-200 bg-slate-50 focus:bg-white focus:ring-1 focus:ring-slate-900 focus:border-slate-900 transition-all outline-none text-sm"
                                    placeholder="Masukkan nama Anda">
                            </div>
                            <div class="space-y-2">
                                <label for="email" class="text-[10px] font-bold uppercase tracking-widest text-slate-900">Alamat Email</label>
                                <input type="email" id="email" required
                                    class="w-full px-4 py-3 border border-slate-200 bg-slate-50 focus:bg-white focus:ring-1 focus:ring-slate-900 focus:border-slate-900 transition-all outline-none text-sm"
                                    placeholder="email@contoh.com">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label for="body" class="text-[10px] font-bold uppercase tracking-widest text-slate-900">Pesan</label>
                            <textarea name="body" id="body" rows="4" required
                                class="w-full px-4 py-3 border border-slate-200 bg-slate-50 focus:bg-white focus:ring-1 focus:ring-slate-900 focus:border-slate-900 transition-all outline-none text-sm resize-none"
                                placeholder="Tuliskan pesan Anda di sini..."></textarea>
                        </div>

                        <button type="submit"
                            class="w-full bg-slate-900 text-white py-4 text-[11px] font-bold uppercase tracking-widest hover:bg-slate-800 transition-all duration-300 flex items-center justify-center gap-3">
                            Kirim Pesan
                            <i class="fas fa-paper-plane text-[10px]"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
