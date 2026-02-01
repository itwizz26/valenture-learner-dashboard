<script setup>
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';
import debounce from 'lodash/debounce';

const props = defineProps({
    learners: Array,
    courses: Array,
    filters: Object
});

const form = ref({
    course_id: props.filters.course_id || '',
    sort_by: props.filters.sort_by || ''
});

watch(form, debounce(() => {
    router.get('/learner-progress', form.value, { 
        preserveState: true, 
        replace: true 
    });
}, 300), { deep: true });

const getProgressBarColor = (progress) => {
    if (progress >= 80) return 'bg-green-500';
    if (progress >= 50) return 'bg-blue-500';
    return 'bg-amber-500';
};

const getInitials = (name) => {
    return name ? name.split(' ').map(n => n[0]).join('').toUpperCase() : '?';
};
</script>

<template>
    <div class="min-h-screen bg-slate-50 p-8 text-slate-900 font-sans">
        <div class="max-w-5xl mx-auto">
            <h1 class="text-4xl font-extrabold tracking-tight mb-8">Learner Progress Dashboard</h1>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 mb-8 flex flex-wrap gap-6 items-end">
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Filter By Course</label>
                    <select v-model="form.course_id" class="w-full border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Courses</option>
                        <option v-for="course in courses" :key="course.id" :value="course.id">
                            {{ course.name }}
                        </option>
                    </select>
                </div>

                <div class="flex-1 min-w-[200px]">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Sort Progress</label>
                    <select v-model="form.sort_by" class="w-full border-slate-200 rounded-xl focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Default (Latest)</option>
                        <option value="progress_desc">Highest First</option>
                        <option value="progress_asc">Lowest First</option>
                    </select>
                </div>
            </div>

            <div class="grid gap-6 md:grid-cols-2">
                <div v-for="learner in learners" :key="learner.id" 
                     class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-md transition-all duration-300">
                    
                    <div class="flex items-center gap-4 mb-6">
                        <div class="h-12 w-12 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-sm shadow-inner">
                            {{ getInitials(learner.full_name) }}
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-slate-800 leading-tight">
                                {{ learner.full_name }}
                            </h2>
                            <p class="text-xs text-slate-400 font-medium uppercase tracking-tighter">Learner ID: #{{ learner.id }}</p>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div v-for="course in learner.courses" :key="course.id" class="group">
                            <div class="flex justify-between items-center text-sm mb-2">
                                <span class="font-bold text-slate-600 group-hover:text-blue-600 transition-colors">
                                    {{ course.name }}
                                </span>
                                <span class="font-mono font-bold text-blue-700 bg-blue-50 px-2 py-0.5 rounded">
                                    {{ course.pivot.progress }}%
                                </span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                                <div :class="['h-full rounded-full transition-all duration-700 ease-out', getProgressBarColor(course.pivot.progress)]"
                                     :style="{ width: course.pivot.progress + '%' }"></div>
                            </div>
                        </div>
                        
                        <p v-if="!learner.courses.length" class="text-sm italic text-slate-400">
                            No active course enrolments found.
                        </p>
                    </div>
                </div>
            </div>

            <div v-if="!learners.length" class="text-center py-20 bg-white rounded-2xl border-2 border-dashed border-slate-200">
                <p class="text-slate-500 font-medium">No learners match your current filter criteria.</p>
                <button @click="form = {course_id: '', sort_by: ''}" class="mt-4 text-blue-600 font-bold hover:underline">Clear all filters</button>
            </div>
        </div>
    </div>
</template>
