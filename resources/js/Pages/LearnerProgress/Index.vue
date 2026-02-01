<script setup>
    import { Head, router } from '@inertiajs/vue3';
    import { reactive, watch } from 'vue';

    const props = defineProps({
        learners: { type: Array, default: () => [] },
        courses: { type: Array, default: () => [] },
        filters: { type: Object, default: () => ({}) }
    });

    const state = reactive({
        course_id: props.filters?.course_id || '',
        sort_by: props.filters?.sort_by || '',
    });

    const applyFilters = () => {
        router.get('/learner-progress', {
            course_id: state.course_id,
            sort_by: state.sort_by
        }, {
            preserveState: true,
            replace: true,
            only: ['learners', 'filters'] 
        });
    };

    watch(() => state.course_id, () => applyFilters());
    watch(() => state.sort_by, () => applyFilters());

    const getProgressBarColor = (progress) => {
        if (progress >= 80) return 'bg-green-500';
        if (progress >= 50) return 'bg-blue-500';
        if (progress >= 40) return 'bg-amber-500';
        return 'bg-red-500';
    };

    const getInitials = (name) => {
        return name ? name.split(' ').map(n => n[0]).join('').toUpperCase() : '?';
    };

    const clearFilters = () => {
        state.course_id = '';
        state.sort_by = '';
    };

    const getExportUrl = () => {
        const params = new URLSearchParams({
            course_id: state.course_id,
            sort_by: state.sort_by
        });
        return `/learner-progress/export?${params.toString()}`;
    };
</script>

<template>
    <Head title="Dashboard" />
    
    <div class="min-h-screen bg-gradient-to-br from-slate-100 via-blue-50 to-indigo-100 p-4 md:p-8 text-slate-900 font-sans">
        <div class="max-w-5xl mx-auto">
            <h1 class="text-4xl font-extrabold tracking-tight mb-8 text-center text-slate-800 drop-shadow-sm">
                Learner Progress Dashboard 1.0
            </h1>

            <div class="sticky top-6 z-50 bg-white/60 backdrop-blur-xl p-6 rounded-2xl shadow-[0_8px_32px_0_rgba(31,38,135,0.07)] border border-white/40 mb-10 flex flex-wrap gap-6 items-center transition-all duration-500">
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-[10px] font-black text-blue-600 uppercase tracking-[0.2em] mb-2 ml-1">Filter By Course</label>
                    <select v-model="state.course_id" class="w-full bg-white/40 border-white/80 backdrop-blur-md rounded-xl text-sm focus:ring-2 focus:ring-blue-400 focus:border-transparent p-3 transition-all cursor-pointer hover:bg-white/60">
                        <option value="">All Courses</option>
                        <option v-for="course in courses" :key="course.id" :value="course.id">
                            {{ course.name }}
                        </option>
                    </select>
                </div>

                <div class="flex-1 min-w-[200px]">
                    <label class="block text-[10px] font-black text-blue-600 uppercase tracking-[0.2em] mb-2 ml-1">Sort By Progress</label>
                    <select v-model="state.sort_by" class="w-full bg-white/40 border-white/80 backdrop-blur-md rounded-xl text-sm focus:ring-2 focus:ring-blue-400 focus:border-transparent p-3 transition-all cursor-pointer hover:bg-white/60">
                        <option value="">Default (Enrolment Date)</option>
                        <option value="desc">Highest Progress First</option>
                        <option value="asc">Lowest Progress First</option>
                    </select>
                </div>

                <div class="w-full md:w-auto self-end md:self-center pt-2 md:pt-4">
                    <a :href="getExportUrl()" 
                       class="flex items-center justify-center gap-2 px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-indigo-200 transition-all hover:-translate-y-1 active:scale-95 w-full md:w-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Export PDF
                    </a>
                </div>
            </div>

            <transition-group 
                tag="div" 
                name="list"
                class="grid gap-6 md:grid-cols-2"
            >
                <div v-for="(learner, index) in learners" :key="learner.id" 
                     class="group bg-white/40 backdrop-blur-md rounded-3xl p-6 shadow-[0_4px_12px_rgba(0,0,0,0.03)] border border-white/70 hover:bg-white/80 hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 ease-out"
                     :style="{ transitionDelay: `${index * 50}ms` }">
                    
                    <div class="flex items-center gap-4 mb-6">
                        <div class="h-14 w-14 rounded-2xl bg-gradient-to-br from-indigo-500 to-blue-600 text-white flex items-center justify-center font-bold text-lg shadow-lg rotate-3 group-hover:rotate-0 transition-transform duration-300">
                            {{ getInitials(learner.full_name) }}
                        </div>
                        <div>
                            <h2 class="text-xl font-black text-slate-800 leading-tight">
                                {{ learner.full_name }}
                            </h2>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">ID: #{{ learner.id }}</p>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div v-for="course in learner.courses" :key="course.id" class="group/course">
                            <div class="flex justify-between items-end text-sm mb-2">
                                <span class="font-bold text-slate-600 group-hover/course:text-indigo-600 transition-colors">
                                    {{ course.name }}
                                </span>
                                <span class="font-mono font-black text-indigo-700 bg-white/80 px-2 py-0.5 rounded-lg border border-white shadow-sm">
                                    {{ course.pivot.progress }}%
                                </span>
                            </div>
                            <div class="w-full bg-slate-200/40 rounded-full h-3 overflow-hidden border border-white/30 p-[2px]">
                                <div :class="['h-full rounded-full transition-all duration-1000 ease-out shadow-sm', getProgressBarColor(course.pivot.progress)]"
                                     :style="{ width: course.pivot.progress + '%' }"></div>
                            </div>
                        </div>
                        
                        <div v-if="!learner.courses || learner.courses.length === 0" class="py-4 text-center bg-slate-50/50 rounded-xl border border-dashed border-slate-200">
                            <p class="text-xs italic text-slate-400">No matching enrolments</p>
                        </div>
                    </div>
                </div>
            </transition-group>

            <div v-if="!learners.length" class="text-center py-20 bg-white/20 backdrop-blur-xl rounded-3xl border-2 border-dashed border-white/60 animate-pulse">
                <p class="text-slate-500 font-bold">The void is empty. Adjust your filters.</p>
                <button @click="clearFilters" class="mt-4 px-6 py-2 bg-indigo-600 text-white rounded-full font-bold hover:bg-indigo-700 transition-all shadow-lg hover:shadow-indigo-200">
                    Reset Dashboard
                </button>
            </div>
        </div>
    </div>
</template>

<style scoped>
    .list-enter-active,
    .list-leave-active {
        transition: all 0.5s ease;
    }
    .list-enter-from,
    .list-leave-to {
        opacity: 0;
        transform: translateY(30px);
    }

    ::-webkit-scrollbar {
        width: 8px;
    }
    ::-webkit-scrollbar-track {
        background: transparent;
    }
    ::-webkit-scrollbar-thumb {
        background: rgba(99, 102, 241, 0.2);
        border-radius: 10px;
    }
    ::-webkit-scrollbar-thumb:hover {
        background: rgba(99, 102, 241, 0.4);
    }
</style>
