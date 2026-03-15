@extends('layouts.app')
@section('title', 'Home - KOKORO')

@section('head')
<style>
    .quiz-option{transition:all .15s}
    .quiz-option:hover{border-color:#fda4af;background:#fff1f2}
    .emoji-grid button{transition:all .15s}
    .emoji-grid button:hover{transform:scale(1.1)}
    .emoji-grid button.matched{opacity:.4;pointer-events:none}
</style>
@endsection

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    {{-- Welcome --}}
    <div class="animate-in">
        <h1 class="text-xl font-bold text-gray-800 dark:text-gray-100">
            <span data-en="Welcome back, {{ $user->name }}" data-jp="おかえりなさい、{{ $user->name }}さん">Welcome back, {{ $user->name }}</span> 👋
        </h1>
        <p class="text-sm text-gray-400 mt-0.5" data-en="Here's your activity overview" data-jp="アクティビティの概要">Here's your activity overview</p>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-3 gap-3 sm:gap-4">
        <a href="{{ route('search') }}" class="card p-4 text-center hover:border-rose-200 dark:hover:border-rose-800 group">
            <div class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $matchCount }}</div>
            <div class="text-xs text-gray-400 font-medium mt-0.5" data-en="Matches" data-jp="マッチ">Matches</div>
        </a>
        <a href="{{ route('who.liked.me') }}" class="card p-4 text-center hover:border-rose-200 dark:hover:border-rose-800 group">
            <div class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $likesReceived }}</div>
            <div class="text-xs text-gray-400 font-medium mt-0.5" data-en="Likes Received" data-jp="もらったいいね">Likes Received</div>
        </a>
        <a href="{{ route('messages.inbox') }}" class="card p-4 text-center hover:border-rose-200 dark:hover:border-rose-800 group">
            <div class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $unreadMessages }}</div>
            <div class="text-xs text-gray-400 font-medium mt-0.5" data-en="Unread" data-jp="未読">Unread</div>
        </a>
    </div>

    {{-- Quick Actions --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
        <a href="{{ route('search') }}" class="card p-3.5 flex items-center gap-3 hover:border-rose-200 dark:hover:border-rose-800">
            <div class="w-9 h-9 rounded-lg bg-rose-50 dark:bg-rose-900/20 flex items-center justify-center shrink-0">
                <svg class="w-4.5 h-4.5 text-rose-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <span class="text-sm font-medium text-gray-700 dark:text-gray-300" data-en="Find People" data-jp="人を探す">Find People</span>
        </a>
        <a href="{{ route('who.liked.me') }}" class="card p-3.5 flex items-center gap-3 hover:border-rose-200 dark:hover:border-rose-800">
            <div class="w-9 h-9 rounded-lg bg-pink-50 dark:bg-pink-900/20 flex items-center justify-center shrink-0">
                <svg class="w-4.5 h-4.5 text-pink-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
            </div>
            <span class="text-sm font-medium text-gray-700 dark:text-gray-300" data-en="Who Liked Me" data-jp="いいねされた">Who Liked Me</span>
        </a>
        <a href="{{ route('messages.inbox') }}" class="card p-3.5 flex items-center gap-3 hover:border-rose-200 dark:hover:border-rose-800">
            <div class="w-9 h-9 rounded-lg bg-violet-50 dark:bg-violet-900/20 flex items-center justify-center shrink-0">
                <svg class="w-4.5 h-4.5 text-violet-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
            </div>
            <span class="text-sm font-medium text-gray-700 dark:text-gray-300" data-en="Messages" data-jp="メッセージ">Messages</span>
        </a>
        <a href="{{ route('profile.show') }}" class="card p-3.5 flex items-center gap-3 hover:border-rose-200 dark:hover:border-rose-800">
            <div class="w-9 h-9 rounded-lg bg-amber-50 dark:bg-amber-900/20 flex items-center justify-center shrink-0">
                <svg class="w-4.5 h-4.5 text-amber-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            </div>
            <span class="text-sm font-medium text-gray-700 dark:text-gray-300" data-en="My Profile" data-jp="プロフィール">My Profile</span>
        </a>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        {{-- Left column: Games & Inspiration --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Mini Games --}}
            <div>
                <h2 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-3" data-en="Mini Games" data-jp="ミニゲーム">Mini Games</h2>
                <div class="grid sm:grid-cols-3 gap-3">
                    <button onclick="startLoveQuiz()" class="card p-4 text-left hover:border-rose-200 dark:hover:border-rose-800">
                        <span class="text-2xl">💕</span>
                        <h3 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mt-2" data-en="Love Quiz" data-jp="恋愛クイズ">Love Quiz</h3>
                        <p class="text-xs text-gray-400 mt-0.5" data-en="Test your love IQ" data-jp="恋愛力をテスト">Test your love IQ</p>
                    </button>
                    <button onclick="showFortune()" class="card p-4 text-left hover:border-violet-200 dark:hover:border-violet-800">
                        <span class="text-2xl">🔮</span>
                        <h3 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mt-2" data-en="Love Fortune" data-jp="恋愛運">Love Fortune</h3>
                        <p class="text-xs text-gray-400 mt-0.5" data-en="Today's fortune" data-jp="今日の運勢">Today's fortune</p>
                    </button>
                    <button onclick="startEmojiMatch()" class="card p-4 text-left hover:border-amber-200 dark:hover:border-amber-800">
                        <span class="text-2xl">🧩</span>
                        <h3 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mt-2" data-en="Emoji Match" data-jp="絵文字マッチ">Emoji Match</h3>
                        <p class="text-xs text-gray-400 mt-0.5" data-en="Find the pairs" data-jp="ペアを探そう">Find the pairs</p>
                    </button>
                </div>
            </div>

            {{-- Blog --}}
            <div>
                <h2 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-3" data-en="Tips & Articles" data-jp="ヒント＆記事">Tips & Articles</h2>
                <div class="space-y-3">
                    <button onclick="openBlogPost(1)" class="card p-4 flex items-center gap-4 w-full text-left hover:border-rose-200 dark:hover:border-rose-800">
                        <span class="text-3xl shrink-0">💌</span>
                        <div class="min-w-0">
                            <span class="tag bg-rose-50 text-rose-500 dark:bg-rose-900/20 dark:text-rose-400 mb-1" data-en="Dating Tips" data-jp="デートのコツ">Dating Tips</span>
                            <h3 class="font-semibold text-gray-800 dark:text-gray-100 text-sm" data-en="5 Tips for a Great First Message" data-jp="最初のメッセージを成功させる5つのコツ">5 Tips for a Great First Message</h3>
                        </div>
                        <svg class="w-4 h-4 text-gray-300 dark:text-gray-600 shrink-0 ml-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </button>
                    <button onclick="openBlogPost(2)" class="card p-4 flex items-center gap-4 w-full text-left hover:border-violet-200 dark:hover:border-violet-800">
                        <span class="text-3xl shrink-0">🌸</span>
                        <div class="min-w-0">
                            <span class="tag bg-violet-50 text-violet-500 dark:bg-violet-900/20 dark:text-violet-400 mb-1" data-en="Culture" data-jp="文化">Culture</span>
                            <h3 class="font-semibold text-gray-800 dark:text-gray-100 text-sm" data-en="Understanding Japanese Dating Culture" data-jp="日本のデート文化を理解する">Understanding Japanese Dating Culture</h3>
                        </div>
                        <svg class="w-4 h-4 text-gray-300 dark:text-gray-600 shrink-0 ml-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </button>
                    <button onclick="openBlogPost(3)" class="card p-4 flex items-center gap-4 w-full text-left hover:border-emerald-200 dark:hover:border-emerald-800">
                        <span class="text-3xl shrink-0">✨</span>
                        <div class="min-w-0">
                            <span class="tag bg-emerald-50 text-emerald-500 dark:bg-emerald-900/20 dark:text-emerald-400 mb-1" data-en="Growth" data-jp="成長">Growth</span>
                            <h3 class="font-semibold text-gray-800 dark:text-gray-100 text-sm" data-en="Building Confidence for Better Connections" data-jp="より良い出会いのために自信をつける">Building Confidence for Better Connections</h3>
                        </div>
                        <svg class="w-4 h-4 text-gray-300 dark:text-gray-600 shrink-0 ml-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Right column: Suggested & Inspiration --}}
        <div class="space-y-6">
            {{-- Suggested Profiles --}}
            @if($suggested->count() > 0)
            <div>
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide" data-en="Suggested" data-jp="おすすめ">Suggested</h2>
                    <a href="{{ route('search') }}" class="text-xs text-rose-500 hover:text-rose-600 font-medium" data-en="See all" data-jp="すべて見る">See all</a>
                </div>
                <div class="space-y-2">
                    @foreach($suggested as $profile)
                        @php $compat = auth()->user()->compatibilityWith($profile); @endphp
                        <a href="{{ route('user.profile', $profile->id) }}" class="card p-3 flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-rose-50 dark:bg-rose-900/20 overflow-hidden shrink-0 border border-rose-100 dark:border-rose-800">
                                @if($profile->profile && $profile->profile->profile_photo)
                                    <img src="{{ asset('storage/' . $profile->profile->profile_photo) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center"><span class="text-sm font-bold text-rose-400">{{ strtoupper(substr($profile->name, 0, 1)) }}</span></div>
                                @endif
                            </div>
                            <div class="min-w-0 flex-1">
                                <h3 class="font-medium text-gray-800 dark:text-gray-100 text-sm truncate">{{ $profile->name }}@if($profile->profile), {{ $profile->profile->age }}@endif</h3>
                                @if($profile->profile && $profile->profile->prefecture)
                                    <p class="text-xs text-gray-400 truncate">{{ $profile->profile->prefecture }}</p>
                                @endif
                            </div>
                            @if($compat > 0)
                                <span class="text-xs font-semibold {{ $compat >= 60 ? 'text-emerald-500' : ($compat >= 30 ? 'text-amber-500' : 'text-gray-400') }} shrink-0">{{ $compat }}%</span>
                            @endif
                        </a>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Daily Inspiration --}}
            <div class="card p-4">
                <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-2" data-en="Daily Inspiration" data-jp="今日のひとこと">Daily Inspiration</h3>
                <p class="text-sm text-gray-600 dark:text-gray-300 italic leading-relaxed" id="daily-quote"></p>
                <p class="text-xs text-gray-400 mt-2" id="daily-quote-author"></p>
            </div>

            {{-- News --}}
            <div class="card p-4">
                <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-3" data-en="What's New" data-jp="お知らせ">What's New</h3>
                <div class="space-y-3">
                    <div class="flex items-start gap-2">
                        <div class="w-1.5 h-1.5 bg-emerald-400 rounded-full mt-1.5 shrink-0"></div>
                        <p class="text-xs text-gray-500 dark:text-gray-400" data-en="New: Emoji Match game is live!" data-jp="新機能：絵文字マッチゲーム公開中!">New: Emoji Match game is live!</p>
                    </div>
                    <div class="flex items-start gap-2">
                        <div class="w-1.5 h-1.5 bg-blue-400 rounded-full mt-1.5 shrink-0"></div>
                        <p class="text-xs text-gray-500 dark:text-gray-400" data-en="Complete profiles get 3x more likes" data-jp="完成したプロフィールは3倍のいいねを獲得">Complete profiles get 3x more likes</p>
                    </div>
                    <div class="flex items-start gap-2">
                        <div class="w-1.5 h-1.5 bg-violet-400 rounded-full mt-1.5 shrink-0"></div>
                        <p class="text-xs text-gray-500 dark:text-gray-400" data-en="Spring matching event this month" data-jp="今月の春マッチングイベント開催中">Spring matching event this month</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Game Modal --}}
<div id="game-modal" class="hidden fixed inset-0 z-[60] flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeGameModal()"></div>
    <div class="relative bg-white dark:bg-gray-900 rounded-2xl shadow-xl w-full max-w-lg p-6 animate-in max-h-[90vh] overflow-y-auto border border-gray-100 dark:border-gray-800">
        <button onclick="closeGameModal()" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
        <div id="game-content"></div>
    </div>
</div>

{{-- Blog Modal --}}
<div id="blog-modal" class="hidden fixed inset-0 z-[60] flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeBlogModal()"></div>
    <div class="relative bg-white dark:bg-gray-900 rounded-2xl shadow-xl w-full max-w-2xl p-6 animate-in max-h-[90vh] overflow-y-auto border border-gray-100 dark:border-gray-800">
        <button onclick="closeBlogModal()" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
        <div id="blog-content"></div>
    </div>
</div>
@endsection

@section('scripts')
<script>
const quotes={en:[{text:"The best thing to hold onto in life is each other.",author:"Audrey Hepburn"},{text:"Love is composed of a single soul inhabiting two bodies.",author:"Aristotle"},{text:"Where there is love there is life.",author:"Mahatma Gandhi"},{text:"To love and be loved is to feel the sun from both sides.",author:"David Viscott"},{text:"The greatest thing you'll ever learn is just to love and be loved in return.",author:"Eden Ahbez"},{text:"Love recognizes no barriers.",author:"Maya Angelou"},{text:"In all the world, there is no heart for me like yours.",author:"Maya Angelou"}],jp:[{text:"人生で一番大切なのは、お互いを持つことです。",author:"オードリー・ヘプバーン"},{text:"愛とは、二つの体に宿る一つの魂である。",author:"アリストテレス"},{text:"愛のあるところに人生がある。",author:"マハトマ・ガンジー"},{text:"愛し愛されることは、両側から太陽を感じることです。",author:"デヴィッド・ヴィスコット"},{text:"あなたが学ぶ最も素晴らしいことは、ただ愛し、愛されることです。",author:"エデン・アーベズ"},{text:"愛は障壁を認めません。",author:"マヤ・アンジェロウ"},{text:"世界中のどの心も、あなたの心ほど私に合うものはありません。",author:"マヤ・アンジェロウ"}]};
function setDailyQuote(){const l=localStorage.getItem('kokoro-lang')||'en';const i=new Date().getDay()%quotes[l].length;const q=quotes[l][i];document.getElementById('daily-quote').textContent='"'+q.text+'"';document.getElementById('daily-quote-author').textContent='— '+q.author}
setDailyQuote();
const origApplyLang=window.applyLanguage;window.applyLanguage=function(l){if(origApplyLang)origApplyLang(l);setDailyQuote()};window.applyLanguage(localStorage.getItem('kokoro-lang')||'en');

function closeGameModal(){document.getElementById('game-modal').classList.add('hidden')}
function openGameModal(h){document.getElementById('game-content').innerHTML=h;document.getElementById('game-modal').classList.remove('hidden')}

const quizQuestions={en:[{q:"What does 'kokuhaku' mean in Japanese dating?",options:["A first date","A love confession","A wedding proposal","A breakup"],answer:1},{q:"Which flower symbolizes love in Japan?",options:["Sakura","Red Rose","Sunflower","Lily"],answer:0},{q:"Ideal first date activity according to surveys?",options:["Movie theater","Coffee shop","Amusement park","Walk in the park"],answer:1},{q:"What does a high KOKORO compatibility score mean?",options:["Same age","Shared hobbies & interests","Same location only","Same gender"],answer:1},{q:"Most popular dating season in Japan?",options:["Summer","Autumn","Spring","Winter"],answer:2}],jp:[{q:"日本のデート文化で「告白」とは？",options:["初デート","愛の告白","プロポーズ","別れ"],answer:1},{q:"日本で愛を象徴する花は？",options:["桜","赤いバラ","ひまわり","ユリ"],answer:0},{q:"理想的な初デートは？",options:["映画館","カフェ","遊園地","公園散歩"],answer:1},{q:"KOKOROの高い相性スコアは？",options:["同じ年齢","共通の趣味と興味","同じ場所のみ","同じ性別"],answer:1},{q:"日本でデートに人気の季節は？",options:["夏","秋","春","冬"],answer:2}]};
let quizState={current:0,score:0,lang:'en'};
function startLoveQuiz(){quizState={current:0,score:0,lang:localStorage.getItem('kokoro-lang')||'en'};showQuizQuestion()}
function showQuizQuestion(){const l=quizState.lang,qs=quizQuestions[l];if(quizState.current>=qs.length){const t=qs.length,p=Math.round(quizState.score/t*100);const m=l==='en'?(p>=80?"Amazing! Love expert! 💕":p>=60?"Great job! 🌸":p>=40?"Not bad! 📚":"Keep learning! 💌"):(p>=80?"すごい！恋愛マスター！💕":p>=60?"よくできました！🌸":p>=40?"まあまあ！📚":"もっと学びましょう！💌");openGameModal(`<div class="text-center py-4"><div class="text-5xl mb-4">${p>=60?'🏆':'💪'}</div><h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-2">${l==='en'?'Quiz Complete!':'クイズ完了！'}</h3><p class="text-gray-400 mb-4">${m}</p><div class="bg-rose-50 dark:bg-rose-900/15 rounded-xl p-5 mb-5"><div class="text-3xl font-bold text-rose-500">${quizState.score}/${t}</div></div><div class="flex gap-2"><button onclick="startLoveQuiz()" class="btn btn-rose flex-1">${l==='en'?'Play Again':'もう一度'}</button><button onclick="closeGameModal()" class="btn btn-ghost flex-1">${l==='en'?'Close':'閉じる'}</button></div></div>`);return}const q=qs[quizState.current];let opts=q.options.map((o,i)=>`<button onclick="answerQuiz(${i})" class="quiz-option w-full text-left p-3 rounded-lg border border-gray-200 dark:border-gray-700 text-sm text-gray-700 dark:text-gray-200 mb-2">${o}</button>`).join('');openGameModal(`<h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-1">${l==='en'?'💕 Love Quiz':'💕 恋愛クイズ'}</h3><p class="text-xs text-gray-400 mb-3">${l==='en'?`Question ${quizState.current+1}/${qs.length}`:`問題 ${quizState.current+1}/${qs.length}`}</p><div class="w-full bg-gray-100 dark:bg-gray-800 rounded-full h-1 mb-5"><div class="h-1 rounded-full bg-rose-500 transition-all" style="width:${quizState.current/qs.length*100}%"></div></div><p class="text-gray-700 dark:text-gray-200 font-medium mb-4 text-sm">${q.q}</p><div>${opts}</div>`)}
function answerQuiz(i){const q=quizQuestions[quizState.lang][quizState.current];if(i===q.answer)quizState.score++;quizState.current++;showQuizQuestion()}

function showFortune(){const l=localStorage.getItem('kokoro-lang')||'en';const f={en:[{level:"Great Luck! 🌟",msg:"Love is in the air today. Make the first move!",color:"text-rose-500"},{level:"Good Luck! ✨",msg:"A meaningful conversation awaits you.",color:"text-violet-500"},{level:"Small Luck! 🍀",msg:"Good things come to those who wait.",color:"text-emerald-500"},{level:"Lucky Day! 💫",msg:"Your charm is at its peak! Update your profile.",color:"text-amber-500"},{level:"Super Luck! 💖",msg:"Someone special is thinking about you!",color:"text-pink-500"}],jp:[{level:"大吉！🌟",msg:"今日は恋の予感。最初の一歩を踏み出しましょう！",color:"text-rose-500"},{level:"中吉！✨",msg:"意味のある会話が待っています。",color:"text-violet-500"},{level:"小吉！🍀",msg:"待つ者に良いことが訪れます。",color:"text-emerald-500"},{level:"吉！💫",msg:"魅力は最高潮！プロフィールを更新しましょう。",color:"text-amber-500"},{level:"超大吉！💖",msg:"誰かがあなたのことを思っています！",color:"text-pink-500"}]};const d=new Date().getDate()%f[l].length;const r=f[l][d];openGameModal(`<div class="text-center py-4"><div class="text-5xl mb-4">🔮</div><h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-2">${l==='en'?"Today's Love Fortune":"今日の恋愛運"}</h3><div class="bg-gray-50 dark:bg-gray-800 rounded-xl p-5 my-5"><div class="text-xl font-bold ${r.color} mb-2">${r.level}</div><p class="text-sm text-gray-600 dark:text-gray-300">${r.msg}</p></div><button onclick="closeGameModal()" class="btn btn-rose">${l==='en'?'Close':'閉じる'}</button></div>`)}

let emojiState={cards:[],flipped:[],matched:[],moves:0,started:false};const emojiSets=['💕','🌸','🎀','🌟','💎','🦋','🌈','🍰'];
function startEmojiMatch(){const e=[...emojiSets,...emojiSets].sort(()=>Math.random()-.5);emojiState={cards:e,flipped:[],matched:[],moves:0,started:true};renderEmojiGame()}
function renderEmojiGame(){const l=localStorage.getItem('kokoro-lang')||'en';let g='<div class="emoji-grid grid grid-cols-4 gap-2 mb-4">';emojiState.cards.forEach((e,i)=>{const f=emojiState.flipped.includes(i)||emojiState.matched.includes(i),m=emojiState.matched.includes(i);g+=`<button onclick="flipEmoji(${i})" class="w-full aspect-square rounded-lg text-xl border ${m?'border-emerald-200 bg-emerald-50 dark:bg-emerald-900/15 matched':f?'border-rose-200 bg-rose-50 dark:bg-rose-900/15':'border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700'} flex items-center justify-center" ${m?'disabled':''}>${f||m?e:'?'}</button>`});g+='</div>';openGameModal(`<h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-1">${l==='en'?'🧩 Emoji Match':'🧩 絵文字マッチ'}</h3><div class="flex gap-4 text-xs text-gray-400 mb-4"><span>${l==='en'?'Moves':'手数'}: <strong class="text-gray-800 dark:text-gray-100">${emojiState.moves}</strong></span><span>${l==='en'?'Pairs':'ペア'}: <strong class="text-gray-800 dark:text-gray-100">${emojiState.matched.length/2}/${emojiSets.length}</strong></span></div>${g}`);if(emojiState.matched.length===emojiState.cards.length){setTimeout(()=>{openGameModal(`<div class="text-center py-4"><div class="text-5xl mb-4">🎉</div><h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-2">${l==='en'?'All pairs found!':'全ペア発見！'}</h3><p class="text-gray-400 mb-5">${l==='en'?`${emojiState.moves} moves`:`${emojiState.moves}手でクリア`}</p><div class="flex gap-2"><button onclick="startEmojiMatch()" class="btn btn-rose flex-1">${l==='en'?'Play Again':'もう一度'}</button><button onclick="closeGameModal()" class="btn btn-ghost flex-1">${l==='en'?'Close':'閉じる'}</button></div></div>`)},600)}}
function flipEmoji(i){if(!emojiState.started||emojiState.flipped.length>=2||emojiState.flipped.includes(i)||emojiState.matched.includes(i))return;emojiState.flipped.push(i);if(emojiState.flipped.length===2){emojiState.moves++;const[a,b]=emojiState.flipped;if(emojiState.cards[a]===emojiState.cards[b]){emojiState.matched.push(a,b);emojiState.flipped=[];renderEmojiGame()}else{renderEmojiGame();setTimeout(()=>{emojiState.flipped=[];renderEmojiGame()},800)}}else{renderEmojiGame()}}

const blogPosts={en:{1:{title:"5 Tips for a Great First Message",cat:"Dating Tips",emoji:"💌",content:`<p class="mb-3 text-sm text-gray-600 dark:text-gray-300">Your first message sets the tone. Here are 5 tips:</p><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-1">1. Be Specific</h4><p class="mb-3 text-sm text-gray-500 dark:text-gray-400">Reference something from their profile instead of generic greetings.</p><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-1">2. Ask a Question</h4><p class="mb-3 text-sm text-gray-500 dark:text-gray-400">Open-ended questions get the best responses.</p><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-1">3. Keep It Light</h4><p class="mb-3 text-sm text-gray-500 dark:text-gray-400">Be fun and easygoing. Save deep topics for later.</p><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-1">4. Show Personality</h4><p class="mb-3 text-sm text-gray-500 dark:text-gray-400">Let your unique character shine through.</p><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-1">5. Be Respectful</h4><p class="text-sm text-gray-500 dark:text-gray-400">A kind message always stands out.</p>`},2:{title:"Understanding Japanese Dating Culture",cat:"Culture",emoji:"🌸",content:`<p class="mb-3 text-sm text-gray-600 dark:text-gray-300">Dating in Japan has unique traditions:</p><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-1">Kokuhaku (Confession)</h4><p class="mb-3 text-sm text-gray-500 dark:text-gray-400">Relationships often begin with a formal confession of feelings.</p><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-1">Seasonal Dating</h4><p class="mb-3 text-sm text-gray-500 dark:text-gray-400">Couples enjoy hanami, fireworks, fall foliage, and Christmas lights.</p><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-1">Gift-Giving</h4><p class="mb-3 text-sm text-gray-500 dark:text-gray-400">Valentine's Day and White Day are major occasions for couples.</p><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-1">Taking It Slow</h4><p class="text-sm text-gray-500 dark:text-gray-400">Building trust and understanding is highly valued.</p>`},3:{title:"Building Confidence for Better Connections",cat:"Self Growth",emoji:"✨",content:`<p class="mb-3 text-sm text-gray-600 dark:text-gray-300">Confidence is attractive. Here's how to build it:</p><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-1">Practice Self-Care</h4><p class="mb-3 text-sm text-gray-500 dark:text-gray-400">Taking care of yourself creates a strong foundation.</p><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-1">Set Small Goals</h4><p class="mb-3 text-sm text-gray-500 dark:text-gray-400">Start by sending one new message each day.</p><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-1">Embrace Uniqueness</h4><p class="mb-3 text-sm text-gray-500 dark:text-gray-400">Your unique qualities are your biggest strengths.</p><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-1">Learn from Experience</h4><p class="text-sm text-gray-500 dark:text-gray-400">Every interaction brings you closer to the right person.</p>`}},jp:{1:{title:"最初のメッセージを成功させる5つのコツ",cat:"デートのコツ",emoji:"💌",content:`<p class="mb-3 text-sm text-gray-600 dark:text-gray-300">最初のメッセージがすべての始まりです：</p><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-1">1. 具体的に</h4><p class="mb-3 text-sm text-gray-500 dark:text-gray-400">相手のプロフィールから何かを参考にしましょう。</p><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-1">2. 質問をする</h4><p class="mb-3 text-sm text-gray-500 dark:text-gray-400">オープンな質問が最も効果的です。</p><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-1">3. 軽い雰囲気で</h4><p class="mb-3 text-sm text-gray-500 dark:text-gray-400">最初は楽しく気軽に。</p><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-1">4. 自分らしさを出す</h4><p class="mb-3 text-sm text-gray-500 dark:text-gray-400">あなたの個性を言葉で表現してください。</p><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-1">5. 礼儀正しく</h4><p class="text-sm text-gray-500 dark:text-gray-400">丁寧さは大切です。</p>`},2:{title:"日本のデート文化を理解する",cat:"文化",emoji:"🌸",content:`<p class="mb-3 text-sm text-gray-600 dark:text-gray-300">日本のデート文化の独特な伝統：</p><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-1">告白文化</h4><p class="mb-3 text-sm text-gray-500 dark:text-gray-400">交際は正式な気持ちの告白から始まります。</p><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-1">季節のデート</h4><p class="mb-3 text-sm text-gray-500 dark:text-gray-400">花見、花火、紅葉、イルミネーションを楽しみます。</p><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-1">贈り物の伝統</h4><p class="mb-3 text-sm text-gray-500 dark:text-gray-400">バレンタインデーとホワイトデーは重要なイベントです。</p><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-1">ゆっくりと</h4><p class="text-sm text-gray-500 dark:text-gray-400">信頼と理解を築くことが大切にされています。</p>`},3:{title:"より良い出会いのために自信をつける",cat:"自己成長",emoji:"✨",content:`<p class="mb-3 text-sm text-gray-600 dark:text-gray-300">自信は最も魅力的な資質です：</p><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-1">セルフケア</h4><p class="mb-3 text-sm text-gray-500 dark:text-gray-400">心身のケアは自信の土台です。</p><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-1">小さな目標を設定</h4><p class="mb-3 text-sm text-gray-500 dark:text-gray-400">まずは毎日1通のメッセージを送ることから。</p><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-1">個性を受け入れる</h4><p class="mb-3 text-sm text-gray-500 dark:text-gray-400">ユニークな性質が最大の強みです。</p><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-1">経験から学ぶ</h4><p class="text-sm text-gray-500 dark:text-gray-400">すべてのやり取りは正しい人に近づけます。</p>`}}};
function openBlogPost(id){const l=localStorage.getItem('kokoro-lang')||'en';const p=blogPosts[l][id];document.getElementById('blog-content').innerHTML=`<div class="mb-3"><span class="text-3xl">${p.emoji}</span></div><span class="tag bg-rose-50 text-rose-500 dark:bg-rose-900/20 dark:text-rose-400">${p.cat}</span><h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 mt-2 mb-4">${p.title}</h3><div>${p.content}</div><div class="mt-5 pt-4 border-t border-gray-100 dark:border-gray-800"><button onclick="closeBlogModal()" class="text-sm text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 font-medium">${l==='en'?'← Back':'← 戻る'}</button></div>`;document.getElementById('blog-modal').classList.remove('hidden')}
function closeBlogModal(){document.getElementById('blog-modal').classList.add('hidden')}
</script>
@endsection
