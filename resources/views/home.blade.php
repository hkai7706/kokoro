@extends('layouts.app')
@section('title', 'Home - KOKORO')

@section('head')
<style>
    .quiz-option{transition:all .15s}
    .quiz-option:hover{border-color:#fda4af;background:#fff1f2}
    .emoji-grid button{transition:all .15s}
    .emoji-grid button:hover{transform:scale(1.05)}
    .emoji-grid button.matched{opacity:.4;pointer-events:none}
</style>
@endsection

@section('content')
<div class="max-w-4xl mx-auto space-y-8">

    {{-- Greeting --}}
    <div class="animate-in">
        <h1 class="text-lg font-bold text-gray-900 dark:text-gray-100">
            <span data-en="Hey {{ $user->name }}," data-jp="{{ $user->name }}さん、">Hey {{ $user->name }},</span>
        </h1>
        <p class="text-sm text-gray-400 mt-0.5" data-en="here's what's happening today." data-jp="今日の状況です。">here's what's happening today.</p>
    </div>

    {{-- Contextual nudge based on user state --}}
    @if($matchCount === 0 && $likesReceived === 0)
        <div class="bg-rose-50 dark:bg-rose-900/10 border border-rose-200/40 dark:border-rose-800/30 rounded-xl p-5 animate-in" style="animation-delay:.05s">
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 bg-rose-100 dark:bg-rose-900/30 rounded-lg flex items-center justify-center shrink-0 mt-0.5">
                    <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <div class="flex-1">
                    <h2 class="text-sm font-semibold text-gray-800 dark:text-gray-100" data-en="Start discovering people" data-jp="人を探してみましょう">Start discovering people</h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 leading-relaxed" data-en="Browse profiles and like someone to create your first match. When they like you back, you can start chatting." data-jp="プロフィールを見ていいねしましょう。相手もいいねしてくれたらマッチ成立、チャットが始まります。">Browse profiles and like someone to create your first match. When they like you back, you can start chatting.</p>
                    <a href="{{ route('search') }}" class="inline-flex items-center gap-1.5 mt-3 btn btn-rose btn-sm">
                        <span data-en="Browse profiles" data-jp="プロフィールを見る">Browse profiles</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>
        </div>
    @elseif($likesReceived > 0 && $matchCount === 0)
        <div class="bg-amber-50 dark:bg-amber-900/10 border border-amber-200/40 dark:border-amber-800/30 rounded-xl p-5 animate-in" style="animation-delay:.05s">
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 bg-amber-100 dark:bg-amber-900/30 rounded-lg flex items-center justify-center shrink-0 mt-0.5">
                    <svg class="w-5 h-5 text-amber-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                </div>
                <div class="flex-1">
                    <h2 class="text-sm font-semibold text-gray-800 dark:text-gray-100">
                        <span data-en="{{ $likesReceived }} {{ $likesReceived === 1 ? 'person likes' : 'people like' }} you" data-jp="{{ $likesReceived }}人があなたにいいねしています">{{ $likesReceived }} {{ $likesReceived === 1 ? 'person likes' : 'people like' }} you</span>
                    </h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5" data-en="Like them back to create a match and start chatting." data-jp="いいね返しでマッチが成立し、チャットが始まります。">Like them back to create a match and start chatting.</p>
                    <a href="{{ route('who.liked.me') }}" class="inline-flex items-center gap-1.5 mt-3 btn btn-rose btn-sm">
                        <span data-en="See who liked you" data-jp="いいねした人を見る">See who liked you</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>
        </div>
    @elseif($unreadMessages > 0)
        <div class="bg-violet-50 dark:bg-violet-900/10 border border-violet-200/40 dark:border-violet-800/30 rounded-xl p-5 animate-in" style="animation-delay:.05s">
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 bg-violet-100 dark:bg-violet-900/30 rounded-lg flex items-center justify-center shrink-0 mt-0.5">
                    <svg class="w-5 h-5 text-violet-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                </div>
                <div class="flex-1">
                    <h2 class="text-sm font-semibold text-gray-800 dark:text-gray-100">
                        <span data-en="You have {{ $unreadMessages }} unread {{ $unreadMessages === 1 ? 'message' : 'messages' }}" data-jp="未読メッセージが{{ $unreadMessages }}件あります">You have {{ $unreadMessages }} unread {{ $unreadMessages === 1 ? 'message' : 'messages' }}</span>
                    </h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5" data-en="Don't keep them waiting!" data-jp="返信しましょう！">Don't keep them waiting!</p>
                    <a href="{{ route('messages.inbox') }}" class="inline-flex items-center gap-1.5 mt-3 btn btn-rose btn-sm">
                        <span data-en="Open messages" data-jp="メッセージを開く">Open messages</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>
        </div>
    @endif

    {{-- Activity numbers --}}
    <div class="grid grid-cols-3 gap-3 animate-in" style="animation-delay:.1s">
        <a href="{{ route('search') }}" class="card p-4 text-center">
            <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 tabular-nums">{{ $matchCount }}</div>
            <div class="text-[11px] text-gray-400 mt-0.5" data-en="Matches" data-jp="マッチ">Matches</div>
        </a>
        <a href="{{ route('who.liked.me') }}" class="card p-4 text-center">
            <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 tabular-nums">{{ $likesReceived }}</div>
            <div class="text-[11px] text-gray-400 mt-0.5" data-en="Likes" data-jp="いいね">Likes</div>
        </a>
        <a href="{{ route('messages.inbox') }}" class="card p-4 text-center">
            <div class="text-2xl font-bold text-gray-900 dark:text-gray-100 tabular-nums">{{ $unreadMessages }}</div>
            <div class="text-[11px] text-gray-400 mt-0.5" data-en="Unread" data-jp="未読">Unread</div>
        </a>
    </div>

    <div class="grid lg:grid-cols-5 gap-6">
        {{-- Left: Suggested profiles --}}
        <div class="lg:col-span-3 space-y-6">
            @if($suggested->count() > 0)
            <div class="animate-in" style="animation-delay:.15s">
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-300" data-en="People you might like" data-jp="おすすめの人">People you might like</h2>
                    <a href="{{ route('search') }}" class="text-xs text-rose-500 hover:text-rose-600 font-medium" data-en="See all" data-jp="すべて見る">See all</a>
                </div>
                <div class="space-y-3">
                    @foreach($suggested as $profile)
                        @php $compat = auth()->user()->compatibilityWith($profile); @endphp
                        <a href="{{ route('user.profile', $profile->id) }}" class="card flex items-center gap-4 p-4 group">
                            <div class="w-14 h-14 rounded-full bg-gray-100 dark:bg-gray-800 overflow-hidden shrink-0">
                                @if($profile->profile && $profile->profile->profile_photo)
                                    <img src="{{ asset('storage/' . $profile->profile->profile_photo) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center"><span class="text-base font-bold text-gray-300 dark:text-gray-600">{{ strtoupper(substr($profile->name, 0, 1)) }}</span></div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2">
                                    <h3 class="font-semibold text-gray-800 dark:text-gray-100 text-sm">{{ $profile->name }}@if($profile->profile), {{ $profile->profile->age }}@endif</h3>
                                    @if($compat >= 60)
                                        <span class="tag bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400">{{ $compat }}%</span>
                                    @elseif($compat >= 30)
                                        <span class="tag bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400">{{ $compat }}%</span>
                                    @endif
                                </div>
                                @if($profile->profile && $profile->profile->prefecture)
                                    <p class="text-xs text-gray-400 mt-0.5">{{ $profile->profile->prefecture }}@if($profile->profile->location) &middot; {{ $profile->profile->location }}@endif</p>
                                @endif
                                @if($profile->profile && $profile->profile->bio)
                                    <p class="text-xs text-gray-400 mt-1 line-clamp-2">{{ $profile->profile->bio }}</p>
                                @endif
                            </div>
                            <svg class="w-4 h-4 text-gray-300 dark:text-gray-600 shrink-0 group-hover:text-rose-400 transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Fun stuff --}}
            <div class="animate-in" style="animation-delay:.2s">
                <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3" data-en="Something fun" data-jp="ちょっと息抜き">Something fun</h2>
                <div class="grid sm:grid-cols-3 gap-3">
                    <button onclick="startLoveQuiz()" class="card p-4 text-left">
                        <div class="text-xl mb-2">&#128149;</div>
                        <h3 class="text-xs font-semibold text-gray-700 dark:text-gray-200" data-en="Love Quiz" data-jp="恋愛クイズ">Love Quiz</h3>
                        <p class="text-[11px] text-gray-400 mt-0.5" data-en="Test your love IQ" data-jp="恋愛力をテスト">Test your love IQ</p>
                    </button>
                    <button onclick="showFortune()" class="card p-4 text-left">
                        <div class="text-xl mb-2">&#128302;</div>
                        <h3 class="text-xs font-semibold text-gray-700 dark:text-gray-200" data-en="Love Fortune" data-jp="恋愛運">Love Fortune</h3>
                        <p class="text-[11px] text-gray-400 mt-0.5" data-en="Today's fortune" data-jp="今日の運勢">Today's fortune</p>
                    </button>
                    <button onclick="startEmojiMatch()" class="card p-4 text-left">
                        <div class="text-xl mb-2">&#129513;</div>
                        <h3 class="text-xs font-semibold text-gray-700 dark:text-gray-200" data-en="Emoji Match" data-jp="絵文字マッチ">Emoji Match</h3>
                        <p class="text-[11px] text-gray-400 mt-0.5" data-en="Find the pairs" data-jp="ペアを探そう">Find the pairs</p>
                    </button>
                </div>
            </div>
        </div>

        {{-- Right column --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="animate-in" style="animation-delay:.2s">
                <div class="card p-4">
                    <p class="text-sm text-gray-600 dark:text-gray-300 italic leading-relaxed" id="daily-quote"></p>
                    <p class="text-[11px] text-gray-400 mt-2" id="daily-quote-author"></p>
                </div>
            </div>

            <div class="animate-in" style="animation-delay:.25s">
                <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3" data-en="Tips & articles" data-jp="ヒント＆記事">Tips & articles</h2>
                <div class="space-y-2">
                    <button onclick="openBlogPost(1)" class="card p-3.5 flex items-center gap-3 w-full text-left">
                        <span class="text-lg shrink-0">&#128140;</span>
                        <div class="min-w-0 flex-1">
                            <h3 class="text-xs font-semibold text-gray-700 dark:text-gray-200" data-en="5 Tips for a Great First Message" data-jp="最初のメッセージを成功させる5つのコツ">5 Tips for a Great First Message</h3>
                            <span class="text-[11px] text-gray-400" data-en="Dating Tips" data-jp="デートのコツ">Dating Tips</span>
                        </div>
                        <svg class="w-3.5 h-3.5 text-gray-300 dark:text-gray-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </button>
                    <button onclick="openBlogPost(2)" class="card p-3.5 flex items-center gap-3 w-full text-left">
                        <span class="text-lg shrink-0">&#127800;</span>
                        <div class="min-w-0 flex-1">
                            <h3 class="text-xs font-semibold text-gray-700 dark:text-gray-200" data-en="Understanding Japanese Dating Culture" data-jp="日本のデート文化を理解する">Understanding Japanese Dating Culture</h3>
                            <span class="text-[11px] text-gray-400" data-en="Culture" data-jp="文化">Culture</span>
                        </div>
                        <svg class="w-3.5 h-3.5 text-gray-300 dark:text-gray-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </button>
                    <button onclick="openBlogPost(3)" class="card p-3.5 flex items-center gap-3 w-full text-left">
                        <span class="text-lg shrink-0">&#10024;</span>
                        <div class="min-w-0 flex-1">
                            <h3 class="text-xs font-semibold text-gray-700 dark:text-gray-200" data-en="Building Confidence for Better Connections" data-jp="より良い出会いのために自信をつける">Building Confidence for Better Connections</h3>
                            <span class="text-[11px] text-gray-400" data-en="Growth" data-jp="成長">Growth</span>
                        </div>
                        <svg class="w-3.5 h-3.5 text-gray-300 dark:text-gray-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </button>
                </div>
            </div>

            <div class="animate-in" style="animation-delay:.3s">
                <h2 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3" data-en="What's new" data-jp="お知らせ">What's new</h2>
                <div class="space-y-2.5 text-xs text-gray-500 dark:text-gray-400">
                    <div class="flex items-start gap-2.5">
                        <div class="w-1.5 h-1.5 bg-emerald-400 rounded-full mt-1.5 shrink-0"></div>
                        <p data-en="New: Emoji Match game is live!" data-jp="新機能：絵文字マッチゲーム公開中!">New: Emoji Match game is live!</p>
                    </div>
                    <div class="flex items-start gap-2.5">
                        <div class="w-1.5 h-1.5 bg-blue-400 rounded-full mt-1.5 shrink-0"></div>
                        <p data-en="Complete profiles get 3x more likes" data-jp="完成したプロフィールは3倍のいいねを獲得">Complete profiles get 3x more likes</p>
                    </div>
                    <div class="flex items-start gap-2.5">
                        <div class="w-1.5 h-1.5 bg-violet-400 rounded-full mt-1.5 shrink-0"></div>
                        <p data-en="Spring matching event this month" data-jp="今月の春マッチングイベント開催中">Spring matching event this month</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Game Modal --}}
<div id="game-modal" class="hidden fixed inset-0 z-[60] flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeGameModal()"></div>
    <div class="relative bg-white dark:bg-gray-900 rounded-xl shadow-xl w-full max-w-lg p-6 animate-in max-h-[90vh] overflow-y-auto border border-gray-200 dark:border-gray-800">
        <button onclick="closeGameModal()" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
        <div id="game-content"></div>
    </div>
</div>

{{-- Blog Modal --}}
<div id="blog-modal" class="hidden fixed inset-0 z-[60] flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeBlogModal()"></div>
    <div class="relative bg-white dark:bg-gray-900 rounded-xl shadow-xl w-full max-w-2xl p-6 animate-in max-h-[90vh] overflow-y-auto border border-gray-200 dark:border-gray-800">
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
function setDailyQuote(){const l=localStorage.getItem('kokoro-lang')||'en';const i=new Date().getDay()%quotes[l].length;const q=quotes[l][i];document.getElementById('daily-quote').textContent='\u201C'+q.text+'\u201D';document.getElementById('daily-quote-author').textContent='\u2014 '+q.author}
setDailyQuote();
const origApplyLang=window.applyLanguage;window.applyLanguage=function(l){if(origApplyLang)origApplyLang(l);setDailyQuote()};window.applyLanguage(localStorage.getItem('kokoro-lang')||'en');

function closeGameModal(){document.getElementById('game-modal').classList.add('hidden')}
function openGameModal(h){document.getElementById('game-content').innerHTML=h;document.getElementById('game-modal').classList.remove('hidden')}

const quizQuestions={en:[{q:"What does 'kokuhaku' mean in Japanese dating?",options:["A first date","A love confession","A wedding proposal","A breakup"],answer:1},{q:"Which flower symbolizes love in Japan?",options:["Sakura","Red Rose","Sunflower","Lily"],answer:0},{q:"Ideal first date activity according to surveys?",options:["Movie theater","Coffee shop","Amusement park","Walk in the park"],answer:1},{q:"What does a high KOKORO compatibility score mean?",options:["Same age","Shared hobbies & interests","Same location only","Same gender"],answer:1},{q:"Most popular dating season in Japan?",options:["Summer","Autumn","Spring","Winter"],answer:2}],jp:[{q:"日本のデート文化で「告白」とは？",options:["初デート","愛の告白","プロポーズ","別れ"],answer:1},{q:"日本で愛を象徴する花は？",options:["桜","赤いバラ","ひまわり","ユリ"],answer:0},{q:"理想的な初デートは？",options:["映画館","カフェ","遊園地","公園散歩"],answer:1},{q:"KOKOROの高い相性スコアは？",options:["同じ年齢","共通の趣味と興味","同じ場所のみ","同じ性別"],answer:1},{q:"日本でデートに人気の季節は？",options:["夏","秋","春","冬"],answer:2}]};
let quizState={current:0,score:0,lang:'en'};
function startLoveQuiz(){quizState={current:0,score:0,lang:localStorage.getItem('kokoro-lang')||'en'};showQuizQuestion()}
function showQuizQuestion(){const l=quizState.lang,qs=quizQuestions[l];if(quizState.current>=qs.length){const t=qs.length,p=Math.round(quizState.score/t*100);const m=l==='en'?(p>=80?"Amazing! Love expert!":p>=60?"Great job!":p>=40?"Not bad!":"Keep learning!"):(p>=80?"すごい！恋愛マスター！":p>=60?"よくできました！":p>=40?"まあまあ！":"もっと学びましょう！");openGameModal(`<div class="text-center py-4"><h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-2">${l==='en'?'Quiz Complete!':'クイズ完了！'}</h3><p class="text-gray-400 text-sm mb-4">${m}</p><div class="bg-rose-50 dark:bg-rose-900/15 rounded-lg p-5 mb-5"><div class="text-3xl font-bold text-rose-500 tabular-nums">${quizState.score}/${t}</div></div><div class="flex gap-2"><button onclick="startLoveQuiz()" class="btn btn-rose flex-1">${l==='en'?'Play Again':'もう一度'}</button><button onclick="closeGameModal()" class="btn btn-ghost flex-1">${l==='en'?'Close':'閉じる'}</button></div></div>`);return}const q=qs[quizState.current];let opts=q.options.map((o,i)=>`<button onclick="answerQuiz(${i})" class="quiz-option w-full text-left p-3 rounded-lg border border-gray-200 dark:border-gray-700 text-sm text-gray-700 dark:text-gray-200 mb-2">${o}</button>`).join('');openGameModal(`<h3 class="text-base font-bold text-gray-800 dark:text-gray-100 mb-1">${l==='en'?'Love Quiz':'恋愛クイズ'}</h3><p class="text-xs text-gray-400 mb-3">${l==='en'?`Question ${quizState.current+1} of ${qs.length}`:`問題 ${quizState.current+1}/${qs.length}`}</p><div class="w-full bg-gray-100 dark:bg-gray-800 rounded-full h-1 mb-5"><div class="h-1 rounded-full bg-rose-500 transition-all" style="width:${quizState.current/qs.length*100}%"></div></div><p class="text-gray-700 dark:text-gray-200 font-medium mb-4 text-sm">${q.q}</p><div>${opts}</div>`)}
function answerQuiz(i){const q=quizQuestions[quizState.lang][quizState.current];if(i===q.answer)quizState.score++;quizState.current++;showQuizQuestion()}

function showFortune(){const l=localStorage.getItem('kokoro-lang')||'en';const f={en:[{level:"Great Luck!",msg:"Love is in the air today. Make the first move!",color:"text-rose-500"},{level:"Good Luck!",msg:"A meaningful conversation awaits you.",color:"text-violet-500"},{level:"Small Luck!",msg:"Good things come to those who wait.",color:"text-emerald-500"},{level:"Lucky Day!",msg:"Your charm is at its peak! Update your profile.",color:"text-amber-500"},{level:"Super Luck!",msg:"Someone special is thinking about you!",color:"text-pink-500"}],jp:[{level:"大吉！",msg:"今日は恋の予感。最初の一歩を踏み出しましょう！",color:"text-rose-500"},{level:"中吉！",msg:"意味のある会話が待っています。",color:"text-violet-500"},{level:"小吉！",msg:"待つ者に良いことが訪れます。",color:"text-emerald-500"},{level:"吉！",msg:"魅力は最高潮！プロフィールを更新しましょう。",color:"text-amber-500"},{level:"超大吉！",msg:"誰かがあなたのことを思っています！",color:"text-pink-500"}]};const d=new Date().getDate()%f[l].length;const r=f[l][d];openGameModal(`<div class="text-center py-4"><h3 class="text-base font-bold text-gray-800 dark:text-gray-100 mb-2">${l==='en'?"Today's Love Fortune":"今日の恋愛運"}</h3><div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-5 my-5"><div class="text-lg font-bold ${r.color} mb-1">${r.level}</div><p class="text-sm text-gray-500 dark:text-gray-400">${r.msg}</p></div><button onclick="closeGameModal()" class="btn btn-ghost">${l==='en'?'Close':'閉じる'}</button></div>`)}

let emojiState={cards:[],flipped:[],matched:[],moves:0,started:false};const emojiSets=['\u{1F495}','\u{1F338}','\u{1F380}','\u{1F31F}','\u{1F48E}','\u{1F98B}','\u{1F308}','\u{1F370}'];
function startEmojiMatch(){const e=[...emojiSets,...emojiSets].sort(()=>Math.random()-.5);emojiState={cards:e,flipped:[],matched:[],moves:0,started:true};renderEmojiGame()}
function renderEmojiGame(){const l=localStorage.getItem('kokoro-lang')||'en';let g='<div class="emoji-grid grid grid-cols-4 gap-2 mb-4">';emojiState.cards.forEach((e,i)=>{const f=emojiState.flipped.includes(i)||emojiState.matched.includes(i),m=emojiState.matched.includes(i);g+=`<button onclick="flipEmoji(${i})" class="w-full aspect-square rounded-lg text-xl border ${m?'border-emerald-200 bg-emerald-50 dark:bg-emerald-900/15 matched':f?'border-rose-200 bg-rose-50 dark:bg-rose-900/15':'border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700'} flex items-center justify-center" ${m?'disabled':''}>${f||m?e:'?'}</button>`});g+='</div>';openGameModal(`<h3 class="text-base font-bold text-gray-800 dark:text-gray-100 mb-1">${l==='en'?'Emoji Match':'絵文字マッチ'}</h3><div class="flex gap-4 text-xs text-gray-400 mb-4"><span>${l==='en'?'Moves':'手数'}: <strong class="text-gray-800 dark:text-gray-100">${emojiState.moves}</strong></span><span>${l==='en'?'Pairs':'ペア'}: <strong class="text-gray-800 dark:text-gray-100">${emojiState.matched.length/2}/${emojiSets.length}</strong></span></div>${g}`);if(emojiState.matched.length===emojiState.cards.length){setTimeout(()=>{openGameModal(`<div class="text-center py-4"><h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-2">${l==='en'?'All pairs found!':'全ペア発見！'}</h3><p class="text-gray-400 text-sm mb-5">${l==='en'?`${emojiState.moves} moves`:`${emojiState.moves}手でクリア`}</p><div class="flex gap-2"><button onclick="startEmojiMatch()" class="btn btn-rose flex-1">${l==='en'?'Play Again':'もう一度'}</button><button onclick="closeGameModal()" class="btn btn-ghost flex-1">${l==='en'?'Close':'閉じる'}</button></div></div>`)},600)}}
function flipEmoji(i){if(!emojiState.started||emojiState.flipped.length>=2||emojiState.flipped.includes(i)||emojiState.matched.includes(i))return;emojiState.flipped.push(i);if(emojiState.flipped.length===2){emojiState.moves++;const[a,b]=emojiState.flipped;if(emojiState.cards[a]===emojiState.cards[b]){emojiState.matched.push(a,b);emojiState.flipped=[];renderEmojiGame()}else{renderEmojiGame();setTimeout(()=>{emojiState.flipped=[];renderEmojiGame()},800)}}else{renderEmojiGame()}}

const blogPosts={en:{1:{title:"5 Tips for a Great First Message",cat:"Dating Tips",content:`<p class="mb-3 text-sm text-gray-600 dark:text-gray-300">Your first message sets the tone. Here are 5 tips:</p><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-1">1. Be Specific</h4><p class="mb-3 text-sm text-gray-500 dark:text-gray-400">Reference something from their profile instead of generic greetings.</p><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-1">2. Ask a Question</h4><p class="mb-3 text-sm text-gray-500 dark:text-gray-400">Open-ended questions get the best responses.</p><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-1">3. Keep It Light</h4><p class="mb-3 text-sm text-gray-500 dark:text-gray-400">Be fun and easygoing. Save deep topics for later.</p><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-1">4. Show Personality</h4><p class="mb-3 text-sm text-gray-500 dark:text-gray-400">Let your unique character shine through.</p><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-1">5. Be Respectful</h4><p class="text-sm text-gray-500 dark:text-gray-400">A kind message always stands out.</p>`},2:{title:"Understanding Japanese Dating Culture",cat:"Culture",content:`<p class="mb-3 text-sm text-gray-600 dark:text-gray-300">Dating in Japan has unique traditions:</p><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-1">Kokuhaku (Confession)</h4><p class="mb-3 text-sm text-gray-500 dark:text-gray-400">Relationships often begin with a formal confession of feelings.</p><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-1">Seasonal Dating</h4><p class="mb-3 text-sm text-gray-500 dark:text-gray-400">Couples enjoy hanami, fireworks, fall foliage, and Christmas lights.</p><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-1">Gift-Giving</h4><p class="mb-3 text-sm text-gray-500 dark:text-gray-400">Valentine's Day and White Day are major occasions for couples.</p><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-1">Taking It Slow</h4><p class="text-sm text-gray-500 dark:text-gray-400">Building trust and understanding is highly valued.</p>`},3:{title:"Building Confidence for Better Connections",cat:"Self Growth",content:`<p class="mb-3 text-sm text-gray-600 dark:text-gray-300">Confidence is attractive. Here's how to build it:</p><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-1">Practice Self-Care</h4><p class="mb-3 text-sm text-gray-500 dark:text-gray-400">Taking care of yourself creates a strong foundation.</p><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-1">Set Small Goals</h4><p class="mb-3 text-sm text-gray-500 dark:text-gray-400">Start by sending one new message each day.</p><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-1">Embrace Uniqueness</h4><p class="mb-3 text-sm text-gray-500 dark:text-gray-400">Your unique qualities are your biggest strengths.</p><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-1">Learn from Experience</h4><p class="text-sm text-gray-500 dark:text-gray-400">Every interaction brings you closer to the right person.</p>`}},jp:{1:{title:"最初のメッセージを成功させる5つのコツ",cat:"デートのコツ",content:`<p class="mb-3 text-sm text-gray-600 dark:text-gray-300">最初のメッセージがすべての始まりです：</p><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-1">1. 具体的に</h4><p class="mb-3 text-sm text-gray-500 dark:text-gray-400">相手のプロフィールから何かを参考にしましょう。</p><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-1">2. 質問をする</h4><p class="mb-3 text-sm text-gray-500 dark:text-gray-400">オープンな質問が最も効果的です。</p><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-1">3. 軽い雰囲気で</h4><p class="mb-3 text-sm text-gray-500 dark:text-gray-400">最初は楽しく気軽に。</p><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-1">4. 自分らしさを出す</h4><p class="mb-3 text-sm text-gray-500 dark:text-gray-400">あなたの個性を言葉で表現してください。</p><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-1">5. 礼儀正しく</h4><p class="text-sm text-gray-500 dark:text-gray-400">丁寧さは大切です。</p>`},2:{title:"日本のデート文化を理解する",cat:"文化",content:`<p class="mb-3 text-sm text-gray-600 dark:text-gray-300">日本のデート文化の独特な伝統：</p><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-1">告白文化</h4><p class="mb-3 text-sm text-gray-500 dark:text-gray-400">交際は正式な気持ちの告白から始まります。</p><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-1">季節のデート</h4><p class="mb-3 text-sm text-gray-500 dark:text-gray-400">花見、花火、紅葉、イルミネーションを楽しみます。</p><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-1">贈り物の伝統</h4><p class="mb-3 text-sm text-gray-500 dark:text-gray-400">バレンタインデーとホワイトデーは重要なイベントです。</p><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-1">ゆっくりと</h4><p class="text-sm text-gray-500 dark:text-gray-400">信頼と理解を築くことが大切にされています。</p>`},3:{title:"より良い出会いのために自信をつける",cat:"自己成長",content:`<p class="mb-3 text-sm text-gray-600 dark:text-gray-300">自信は最も魅力的な資質です：</p><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-1">セルフケア</h4><p class="mb-3 text-sm text-gray-500 dark:text-gray-400">心身のケアは自信の土台です。</p><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-1">小さな目標を設定</h4><p class="mb-3 text-sm text-gray-500 dark:text-gray-400">まずは毎日1通のメッセージを送ることから。</p><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-1">個性を受け入れる</h4><p class="mb-3 text-sm text-gray-500 dark:text-gray-400">ユニークな性質が最大の強みです。</p><h4 class="font-semibold text-gray-800 dark:text-gray-100 text-sm mb-1">経験から学ぶ</h4><p class="text-sm text-gray-500 dark:text-gray-400">すべてのやり取りは正しい人に近づけます。</p>`}}};
function openBlogPost(id){const l=localStorage.getItem('kokoro-lang')||'en';const p=blogPosts[l][id];document.getElementById('blog-content').innerHTML=`<span class="text-[11px] font-medium text-gray-400 uppercase tracking-wider">${p.cat}</span><h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 mt-1 mb-4">${p.title}</h3><div>${p.content}</div><div class="mt-5 pt-4 border-t border-gray-100 dark:border-gray-800"><button onclick="closeBlogModal()" class="text-sm text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 font-medium">\u2190 ${l==='en'?'Back':'戻る'}</button></div>`;document.getElementById('blog-modal').classList.remove('hidden')}
function closeBlogModal(){document.getElementById('blog-modal').classList.add('hidden')}
</script>
@endsection
