<center>
                @if ($type == null || $city == null)
                    <div class="alert alert-danger">
                        <h4>
                        ❌ERROR: Тип героя или город не найден, пожалуйста нажмите
                        "профиль" и перейдите обратно на эту страницу (используя навигационные ссылки)
                        или перезайдите на сайт❌
                        </h4>
                    </div>
                @endif
                @foreach ($errors->all() as $message)
                    <div class="notice error">
                        {{ $message }}
                    </div>
                @endforeach
                @if (session()->has('success'))
                    <div class="notice success">
                        {{ session()->get('success') }}
                    </div>
                @endif

                <h1>Герои {{ $type != null ? $type : old('type') }}
                    ({{ $city != null ? $city : old('city') }}) (Ваши Добавленные Герои)</h1>

                <div style="background-color: rgba(255, 252, 252, 0.5);
                    margin-bottom: 0.5rem;
                    font-size: 1.5rem;
                    font-family: inherit;
                    color: #aea6a6;">
                        ВСЕГО {{ $heroes->total() }} ГЕРОЕВ
                </div>

                @if ($heroes->count() > 0)
                    @foreach ($heroes as $hero)
                        <div class="wrapper_for_hero">

                            @if ($hero->isCheck == 0 )
                                <div class="alert alert-warning">
                                    ⏳Герой на проверке⏳
                                </div>
                            @else
                                <div class="alert alert-success">
                                    ✅Герой проверен и выложен✅
                                </div>
                            @endif

                            @if ($role == "admin" || $role == "moder")
                                <h3>
                                    Отправил : {{ $hero->user->first_name }} {{ $hero->user->last_name }}
                                    | id: {{ $hero->user->id }}
                                </h3>
                            @endif


                            <h2>{{ $hero->name_hero }}</h2>
                            <h4>{{ $hero->description_hero }}</h4>

                            <img class="img_hero" src="{{ asset('storage/' . $hero->image_hero) }}" alt="{{ $hero->name_hero }} (картинка не найден) | " />

                            <img class="img_qr" src="{{ asset('storage/' . $hero->image_qr) }}" alt="QR код {{ $hero->name_hero }} (картинка не найден)" />
                            
                            <!-- moder -->
                            @if ($role == "moder")
                                <!-- upload hero -->
                                @if (!$hero->isCheck)
                                    <form action="{{ route('upload_hero') }}" method="post" >
                                        @csrf
                                        <input type="hidden" name="id_hero"
                                            value="{{ $hero->id }}" />

                                        <input type="hidden" name="type"
                                            value="{{ $type }}" />

                                        <button type="submit" class="edit_hero" style="background-color: rgb(52, 199, 89);">
                                            ВЫЛОЖИТЬ
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('for_verification') }}" method="post" >
                                        @csrf
                                        <input type="hidden" name="id_hero"
                                            value="{{ $hero->id }}" />

                                        <input type="hidden" name="type"
                                            value="{{ $type }}" />

                                        <button type="submit" class="edit_hero" style="background-color: red;">
                                            НА ПРОВЕРКУ
                                        </button>
                                    </form>
                                @endif
                                
                                <!-- add status -->
                                <form action="{{ $type == "ВОВ" ? route('add_status_hero_vov')
                                                : route('add_status_hero_svo')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="id_hero"
                                        value="{{ $hero->id }}" />

                                    <button type="submit" class="edit_hero">
                                        ДОБАВИТЬ СТАТУС
                                    </button>
                                </form>
                            
                            <!-- user -->
                            @elseif ($role == "user")
                                <!-- edit hero -->
                                <form action="{{ route('edit_hero_user_page') }}" method="post" >
                                    @csrf
                                    <input type="hidden" name="id_hero"
                                        value="{{ $hero->id }}" />

                                    <button type="submit" class="edit_hero">
                                        ИЗМЕНИТЬ
                                    </button>
                                </form>

                                <!-- delete hero -->
                                <form action="{{ route('delete_hero') }}" method="post"
                                onsubmit="return confirm('Вы уверены, что хотите удалить этого героя?')">
                                    @csrf
                                    <input type="hidden" name="id_hero"
                                        value="{{ $hero->id }}" />

                                    <button type="submit" id="btn_delete" class="delete_hero">
                                        УДАЛИТЬ
                                    </button>
                                </form>

                            <!-- admin -->
                            @elseif ($role == "admin")
                                <!-- edit -->
                                <form action="{{ route('edit_hero_user_page') }}" method="post" >
                                    @csrf
                                    <input type="hidden" name="id_hero"
                                        value="{{ $hero->id }}" />

                                    <button type="submit" class="edit_hero">
                                        ИЗМЕНИТЬ
                                    </button>
                                </form>

                                <!-- add status -->
                                <form action="{{ $type == "ВОВ" ? route('add_status_hero_vov')
                                                : route('add_status_hero_svo')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="id_hero"
                                        value="{{ $hero->id }}" />

                                    <button type="submit" class="edit_hero">
                                        ДОБАВИТЬ СТАТУС
                                    </button>
                                </form>

                                <!-- upload hero -->
                                @if (!$hero->isCheck)
                                    @if (!$hero->isCheck)
                                    <form action="{{ route('upload_hero') }}" method="post" >
                                        @csrf
                                        <input type="hidden" name="id_hero"
                                            value="{{ $hero->id }}" />

                                        <input type="hidden" name="type"
                                            value="{{ $type }}" />

                                        <button type="submit" class="edit_hero" style="background-color: rgb(52, 199, 89);">
                                            ВЫЛОЖИТЬ
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('for_verification') }}" method="post" >
                                        @csrf
                                        <input type="hidden" name="id_hero"
                                            value="{{ $hero->id }}" />

                                        <input type="hidden" name="type"
                                            value="{{ $type }}" />

                                        <button type="submit" class="edit_hero" style="background-color: red;">
                                            НА ПРОВЕРКУ
                                        </button>
                                    </form>
                                @endif
                                
                                <!-- delete hero -->
                                <form action="{{ route('delete_hero') }}" method="post"
                                onsubmit="return confirm('Вы уверены, что хотите удалить этого героя?')">
                                     @csrf
                                    <input type="hidden" name="id_hero"
                                        value="{{ $hero->id }}" />

                                    <button type="submit" id="btn_delete" class="delete_hero">
                                        УДАЛИТЬ
                                    </button>
                                </form>
                            @endif
                        @endif

                        </div>
                    @endforeach

                    <!-- pagination -->
                    <div>
                        <div style=" background-color: rgba(255, 252, 252, 0.5);
                            margin-bottom: 0.5rem;
                            font-size: 1.5rem;
                            font-family: inherit;
                            color: #aea6a6;">
                                ВСЕГО {{ $heroes->total() }} ГЕРОЕВ
                        </div>

                        <div style="display: grid;justify-content: center;">
                            {!! $heroes->links('vendor.pagination.bootstrap-4') !!}

                        </div>
                    </div>
                @else
                    <div class="alert alert-info">
                        Нет данных для отображения
                    </div>
                @endif
            </center>

                
