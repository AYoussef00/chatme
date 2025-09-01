<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { ref, onMounted, computed } from 'vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import {
    Upload, MessageCircle, FileText, Sparkles, Zap, Shield, Users,
    ArrowRight, X, CheckCircle, Brain, Globe, Infinity,
    Star, Crown, BookOpen, TrendingUp, BarChart3, Lightbulb, GraduationCap
} from 'lucide-vue-next';

// Types

interface Plan {
    id: number;
    name: string;
    description: string | null;
    price: number;
    duration: string;
    features: string[] | null;
    is_active: boolean;
}

interface UploadedFile {
    name: string;
    type: string;
    size: number;
}

// Props
interface Props {
    plans?: Plan[];
}

const props = withDefaults(defineProps<Props>(), {
    plans: () => []
});

// Reactive data
const isUploading = ref(false);
const uploadedFile = ref<UploadedFile | null>(null);
const showChat = ref(false);
const showPlans = ref(false);
const showLoginModal = ref(false);
const showSignupModal = ref(false);
const isLoginMode = ref(true);

// File upload handling
const handleFileUpload = (event: Event) => {
    const target = event.target as HTMLInputElement;
    const file = target.files?.[0];
    if (file && file.type === 'application/pdf') {
        isUploading.value = true;
        uploadedFile.value = {
            name: file.name,
            type: file.type,
            size: file.size
        };

        setTimeout(() => {
            isUploading.value = false;
        }, 2000);
    }
};

const removeFile = () => {
    uploadedFile.value = null;
    showChat.value = false;
    showPlans.value = false;
};

const closePlans = () => {
    showPlans.value = false;
};

const openLoginModal = () => {
    showLoginModal.value = true;
    isLoginMode.value = true;
};

const openSignupModal = () => {
    showSignupModal.value = true;
    isLoginMode.value = false;
};

const closeAuthModal = () => {
    showLoginModal.value = false;
    showSignupModal.value = false;
};

const toggleAuthMode = () => {
    isLoginMode.value = !isLoginMode.value;
};

const startFreeChat = () => {
    // Close plans modal and show login modal
    closePlans();
    openSignupModal();
};

// Chat functionality
const startChat = () => {
    if (uploadedFile.value) {
        showPlans.value = true;
    }
};

// Form data
const loginForm = ref({
    email: '',
    password: ''
});

const signupForm = ref({
    name: '',
    email: '',
    password: '',
    confirmPassword: ''
});

const isSubmitting = ref(false);

// Computed properties for form binding
const emailValue = computed({
    get: () => isLoginMode.value ? loginForm.value.email : signupForm.value.email,
    set: (value) => {
        if (isLoginMode.value) {
            loginForm.value.email = value;
        } else {
            signupForm.value.email = value;
        }
    }
});

const passwordValue = computed({
    get: () => isLoginMode.value ? loginForm.value.password : signupForm.value.password,
    set: (value) => {
        if (isLoginMode.value) {
            loginForm.value.password = value;
        } else {
            signupForm.value.password = value;
        }
    }
});

const handleLogin = async () => {
    isSubmitting.value = true;
    // Simulate API call
    setTimeout(() => {
        isSubmitting.value = false;
        closeAuthModal();
        // Redirect to dashboard or show success message
    }, 1500);
};

const handleSignup = async () => {
    isSubmitting.value = true;
    // Simulate API call
    setTimeout(() => {
        isSubmitting.value = false;
        closeAuthModal();
        // Redirect to dashboard or show success message
    }, 1500);
};

const handleGoogleAuth = async () => {
    isSubmitting.value = true;
    // Simulate Google OAuth
    setTimeout(() => {
        isSubmitting.value = false;
        closeAuthModal();
        // Redirect to dashboard or show success message
    }, 1500);
};



// Animations
onMounted(() => {
    const elements = document.querySelectorAll('.animate-on-scroll');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
            }
        });
    });
    elements.forEach(el => observer.observe(el));
});
</script>

<template>
    <Head title="ChatMe - AI Document Intelligence">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>

    <div class="min-h-screen bg-black relative overflow-hidden">
        <!-- Animated Background -->
        <div class="fixed inset-0 bg-gradient-to-br from-black via-gray-900 to-black">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_50%,rgba(120,119,198,0.1),transparent_50%)]"></div>
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_80%_20%,rgba(120,119,198,0.05),transparent_50%)]"></div>
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_20%_80%,rgba(120,119,198,0.05),transparent_50%)]"></div>
        </div>

        <!-- Floating Particles -->
        <div class="fixed inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-1/4 left-1/4 w-2 h-2 bg-blue-400/30 rounded-full animate-float"></div>
            <div class="absolute top-1/3 right-1/3 w-1 h-1 bg-purple-400/40 rounded-full animate-float" style="animation-delay: 1s;"></div>
            <div class="absolute top-2/3 left-1/3 w-1.5 h-1.5 bg-pink-400/30 rounded-full animate-float" style="animation-delay: 2s;"></div>
            <div class="absolute top-1/2 right-1/4 w-1 h-1 bg-emerald-400/40 rounded-full animate-float" style="animation-delay: 3s;"></div>
            <div class="absolute bottom-1/4 left-1/2 w-2 h-2 bg-cyan-400/30 rounded-full animate-float" style="animation-delay: 4s;"></div>
        </div>

        <!-- Header Navigation -->
        <header class="fixed top-0 left-0 right-0 z-50 bg-black/80 backdrop-blur-xl border-b border-white/10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6">
                <div class="flex h-16 sm:h-20 items-center justify-between">
                    <div class="flex items-center space-x-2 sm:space-x-4">
                        <div class="relative">
                            <div class="flex h-10 w-10 sm:h-12 sm:w-12 items-center justify-center rounded-2xl bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 p-0.5">
                                <div class="flex h-full w-full items-center justify-center rounded-2xl bg-black">
                                    <Bot class="h-5 w-5 sm:h-6 sm:w-6 text-white" />
                                </div>
                            </div>
                            <div class="absolute -top-1 -right-1 h-3 w-3 sm:h-4 sm:w-4 rounded-full bg-green-400 animate-pulse"></div>
                        </div>
                        <div>
                            <span class="text-lg sm:text-2xl font-bold bg-gradient-to-r from-white to-gray-300 bg-clip-text text-transparent">ChatMe</span>
                            <div class="text-xs text-gray-500 font-mono hidden sm:block">AI-Powered</div>
                        </div>
                    </div>

                    <div class="flex items-center space-x-2 sm:space-x-6">
                        <Link
                            v-if="$page.props.auth.user"
                            href="/dashboard"
                            class="inline-flex items-center rounded-xl bg-white/10 px-3 py-2 sm:px-6 sm:py-3 text-xs sm:text-sm font-medium text-white hover:bg-white/20 transition-all duration-300 border border-white/20 hover:border-white/40"
                        >
                            <span class="hidden sm:inline">Dashboard</span>
                            <span class="sm:hidden">Dash</span>
                        </Link>
                        <template v-else>
                            <button
                                @click="openLoginModal"
                                class="text-xs sm:text-sm font-medium text-gray-400 hover:text-white transition-colors duration-300 hidden sm:block"
                            >
                                Sign in
                            </button>
                            <button
                                @click="openSignupModal"
                                class="inline-flex items-center rounded-xl bg-gradient-to-r from-blue-500 to-purple-600 px-3 py-2 sm:px-6 sm:py-3 text-xs sm:text-sm font-medium text-white hover:from-blue-600 hover:to-purple-700 transition-all duration-300 shadow-lg hover:shadow-blue-500/25"
                            >
                                <span class="hidden sm:inline">Get Started</span>
                                <span class="sm:hidden">Start</span>
                            </button>
                        </template>
                    </div>
                </div>
            </div>
        </header>

        <!-- Hero Section -->
        <div class="relative z-10 pt-24 sm:pt-28 lg:pt-32 pb-16 sm:pb-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6">
                <div class="grid lg:grid-cols-2 gap-8 lg:gap-12 items-center">
                    <!-- Left Column - Text Content -->
                    <div class="space-y-6 sm:space-y-8 text-center lg:text-left">
                        <div class="inline-flex items-center rounded-3xl bg-white/5 backdrop-blur-sm border border-white/10 px-4 sm:px-6 py-2 sm:py-3 text-xs sm:text-sm font-medium text-white shadow-2xl">
                            <div class="flex items-center space-x-2 sm:space-x-3">
                                <div class="relative">
                                    <div class="h-2 w-2 sm:h-3 sm:w-3 rounded-full bg-green-400 animate-pulse"></div>
                                    <div class="absolute inset-0 h-2 w-2 sm:h-3 sm:w-3 rounded-full bg-green-400 animate-ping"></div>
                                </div>
                                <span class="font-semibold text-xs sm:text-sm">AI Document Intelligence</span>
                            </div>
                            <div class="ml-2 sm:ml-3 p-1 sm:p-1.5 rounded-full bg-gradient-to-r from-purple-500/20 to-pink-500/20 border border-purple-400/30">
                                <Sparkles class="h-3 w-3 sm:h-4 sm:w-4 text-purple-300 animate-bounce" />
                            </div>
                        </div>

                        <div class="space-y-4 sm:space-y-6">
                            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-black text-white leading-tight">
                                <span class="bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 bg-clip-text text-transparent animate-pulse">AI Document</span>
                                <br>
                                <span class="bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-500 bg-clip-text text-transparent">Intelligence</span>
                            </h1>

                            <p class="text-base sm:text-lg lg:text-xl text-gray-300 leading-relaxed max-w-2xl mx-auto lg:mx-0 font-light">
                                Transform any PDF into an intelligent conversation partner. Ask questions, get insights, and unlock the hidden knowledge within your documents using cutting-edge AI technology.
                            </p>
                        </div>

                        <!-- Animated Dots -->
                        <div class="flex space-x-2 justify-center lg:justify-start">
                            <div class="w-2 h-2 sm:w-3 sm:h-3 bg-blue-400 rounded-full animate-bounce"></div>
                            <div class="w-2 h-2 sm:w-3 sm:h-3 bg-purple-400 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                            <div class="w-2 h-2 sm:w-3 sm:h-3 bg-pink-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                            <div class="w-2 h-2 sm:w-3 sm:h-3 bg-emerald-400 rounded-full animate-bounce" style="animation-delay: 0.3s"></div>
                        </div>

                        <!-- Feature Pills -->
                        <div class="flex flex-wrap gap-2 sm:gap-4 justify-center lg:justify-start">
                            <div class="flex items-center space-x-2 px-3 sm:px-4 py-1.5 sm:py-2 rounded-full bg-white/5 border border-white/10 backdrop-blur-sm">
                                <Shield class="w-3 h-3 sm:w-4 sm:h-4 text-green-400" />
                                <span class="text-xs sm:text-sm text-white">Secure & Private</span>
                            </div>
                            <div class="flex items-center space-x-2 px-3 sm:px-4 py-1.5 sm:py-2 rounded-full bg-white/5 border border-white/10 backdrop-blur-sm">
                                <Zap class="w-3 h-3 sm:w-4 sm:h-4 text-blue-400" />
                                <span class="text-xs sm:text-sm text-white">Lightning Fast</span>
                            </div>
                            <div class="flex items-center space-x-2 px-3 sm:px-4 py-1.5 sm:py-2 rounded-full bg-white/5 border border-white/10 backdrop-blur-sm">
                                <Brain class="w-3 h-3 sm:w-4 sm:h-4 text-purple-400" />
                                <span class="text-xs sm:text-sm text-white">AI Powered</span>
                            </div>
                        </div>



                        <!-- Stats -->
                        <div class="flex items-center justify-center lg:justify-start space-x-4 sm:space-x-8 pt-6 sm:pt-8">
                            <div class="text-center">
                                <div class="text-lg sm:text-2xl font-bold text-white">10K+</div>
                                <div class="text-xs sm:text-sm text-gray-400">Active Users</div>
                            </div>
                            <div class="text-center">
                                <div class="text-lg sm:text-2xl font-bold text-white">1M+</div>
                                <div class="text-xs sm:text-sm text-gray-400">Documents Processed</div>
                            </div>
                            <div class="text-center">
                                <div class="text-lg sm:text-2xl font-bold text-white">99.9%</div>
                                <div class="text-xs sm:text-sm text-gray-400">Uptime</div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - File Upload Area -->
                    <div class="relative">
                        <!-- Enhanced Background Glow Effects -->
                        <div class="absolute -inset-8 bg-gradient-to-r from-blue-500/20 via-purple-500/20 to-pink-500/20 rounded-3xl blur-3xl animate-pulse"></div>
                        <div class="absolute -inset-4 bg-gradient-to-r from-blue-600/10 via-purple-600/10 to-pink-600/10 rounded-3xl blur-2xl animate-pulse" style="animation-delay: 2s"></div>

                        <!-- File Upload Zone -->
                        <Label for="pdf-upload" class="cursor-pointer block">
                            <div class="group relative rounded-2xl sm:rounded-3xl border-2 border-dashed border-white/20 bg-gradient-to-br from-white/10 via-white/5 to-white/10 p-8 sm:p-12 lg:p-16 text-center transition-all duration-700 hover:border-blue-500/50 hover:bg-white/15 backdrop-blur-2xl hover-lift shadow-2xl hover:shadow-blue-500/25 overflow-hidden">

                                <!-- Animated Background Pattern -->
                                <div class="absolute inset-0 bg-[radial-gradient(circle_at_30%_20%,rgba(168,85,247,0.1)_0%,transparent_50%),radial-gradient(circle_at_70%_80%,rgba(59,130,246,0.1)_0%,transparent_50%)] rounded-3xl"></div>

                                <!-- Floating Decorative Elements -->
                                <div class="absolute top-6 right-6 w-3 h-3 bg-purple-400 rounded-full animate-pulse"></div>
                                <div class="absolute bottom-6 left-6 w-2 h-2 bg-blue-400 rounded-full animate-pulse" style="animation-delay: 1s"></div>
                                <div class="absolute top-1/2 left-6 w-1.5 h-1.5 bg-pink-400 rounded-full animate-pulse" style="animation-delay: 2s"></div>

                                <div v-if="!uploadedFile" class="relative space-y-8">
                                    <!-- Enhanced Upload Icon Container -->
                                    <div class="relative">
                                        <!-- Main Icon Circle -->
                                        <div class="mx-auto w-20 h-20 sm:w-24 sm:h-24 lg:w-32 lg:h-32 rounded-full bg-gradient-to-br from-blue-500/30 via-purple-500/30 to-pink-500/30 border-2 border-white/20 flex items-center justify-center group-hover:scale-110 transition-all duration-700 animate-scale shadow-2xl">
                                            <div class="relative">
                                                <Upload class="h-10 w-10 sm:h-12 sm:w-12 lg:h-16 lg:w-16 text-white group-hover:text-blue-200 transition-all duration-500" />
                                                <!-- Animated Rings -->
                                                <div class="absolute inset-0 w-10 h-10 sm:w-12 sm:h-12 lg:w-16 lg:h-16 border-2 border-blue-400/40 rounded-full animate-ping"></div>
                                                <div class="absolute inset-0 w-10 h-10 sm:w-12 sm:h-12 lg:w-16 lg:h-16 border-2 border-purple-400/40 rounded-full animate-ping" style="animation-delay: 0.5s"></div>
                                                <div class="absolute inset-0 w-10 h-10 sm:w-12 sm:h-12 lg:w-16 lg:h-16 border-2 border-pink-400/40 rounded-full animate-ping" style="animation-delay: 1s"></div>
                                            </div>
                                        </div>

                                        <!-- Floating Particles Around Icon -->
                                        <div class="absolute -top-2 -left-2 w-4 h-4 bg-blue-400/60 rounded-full animate-bounce"></div>
                                        <div class="absolute -top-2 -right-2 w-3 h-3 bg-purple-400/60 rounded-full animate-bounce" style="animation-delay: 0.3s"></div>
                                        <div class="absolute -bottom-2 -left-2 w-3 h-3 bg-pink-400/60 rounded-full animate-bounce" style="animation-delay: 0.6s"></div>
                                        <div class="absolute -bottom-2 -right-2 w-4 h-4 bg-cyan-400/60 rounded-full animate-bounce" style="animation-delay: 0.9s"></div>
                                    </div>

                                                                        <!-- Enhanced Text Content -->
                                    <div class="space-y-3 sm:space-y-4">
                                        <h3 class="text-xl sm:text-2xl lg:text-3xl font-black text-black group-hover:text-gray-800 transition-colors duration-500">
                                            Upload Your Document
                                        </h3>
                                        <p class="text-gray-700 text-sm sm:text-base max-w-sm mx-auto leading-relaxed font-light">
                                            Drag and drop your PDF file here or click anywhere to browse and start your AI journey
                                        </p>

                                        <!-- Interactive Hint -->
                                        <div class="inline-flex items-center space-x-2 px-3 sm:px-4 py-1.5 sm:py-2 rounded-full bg-white/80 border border-gray-200 backdrop-blur-sm">
                                            <div class="w-1.5 h-1.5 sm:w-2 sm:h-2 bg-green-500 rounded-full animate-pulse"></div>
                                            <span class="text-xs sm:text-sm text-black font-medium">Click anywhere to upload</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Upload Progress State -->
                                <div v-else-if="isUploading" class="relative space-y-8">
                                    <!-- Enhanced Uploading Icon -->
                                    <div class="relative">
                                        <div class="mx-auto w-32 h-32 rounded-full bg-gradient-to-br from-blue-500/30 via-purple-500/30 to-pink-500/30 border-2 border-white/20 flex items-center justify-center shadow-2xl">
                                            <div class="relative">
                                                <Upload class="h-16 w-16 text-white animate-bounce" />
                                                <!-- Multiple Animated Rings -->
                                                <div class="absolute inset-0 w-16 h-16 border-2 border-blue-400/40 rounded-full animate-ping"></div>
                                                <div class="absolute inset-0 w-16 h-16 border-2 border-purple-400/40 rounded-full animate-ping" style="animation-delay: 0.3s"></div>
                                                <div class="absolute inset-0 w-16 h-16 border-2 border-pink-400/40 rounded-full animate-ping" style="animation-delay: 0.6s"></div>
                                            </div>
                                        </div>

                                        <!-- Floating Particles -->
                                        <div class="absolute -top-2 -left-2 w-4 h-4 bg-blue-400/60 rounded-full animate-bounce"></div>
                                        <div class="absolute -top-2 -right-2 w-3 h-3 bg-purple-400/60 rounded-full animate-bounce" style="animation-delay: 0.3s"></div>
                                        <div class="absolute -bottom-2 -left-2 w-3 h-3 bg-pink-400/60 rounded-full animate-bounce" style="animation-delay: 0.6s"></div>
                                        <div class="absolute -bottom-2 -right-2 w-4 h-4 bg-cyan-400/60 rounded-full animate-bounce" style="animation-delay: 0.9s"></div>
                                    </div>

                                    <div class="space-y-6">
                                        <h3 class="text-3xl font-black text-black">
                                            Uploading Document...
                                        </h3>
                                        <p class="text-gray-700 text-base max-w-sm mx-auto leading-relaxed font-light">
                                            Please wait while we process your PDF file with our advanced AI
                                        </p>

                                        <!-- Enhanced Progress Bar -->
                                        <div class="w-full max-w-md mx-auto">
                                            <div class="relative w-full bg-white/10 rounded-full h-3 overflow-hidden shadow-inner">
                                                <div class="bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 h-3 rounded-full animate-progress shimmer"></div>
                                            </div>
                                            <div class="flex justify-between text-sm text-gray-400 mt-3">
                                                <span class="font-medium">Processing...</span>
                                                <span class="font-bold animate-pulse">100%</span>
                                            </div>
                                        </div>

                                        <!-- Enhanced Loading Dots -->
                                        <div class="flex justify-center space-x-3">
                                            <div class="w-3 h-3 bg-blue-400 rounded-full animate-bounce"></div>
                                            <div class="w-3 h-3 bg-purple-400 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                                            <div class="w-3 h-3 bg-pink-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                                            <div class="w-3 h-3 bg-cyan-400 rounded-full animate-bounce" style="animation-delay: 0.3s"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Success State -->
                                <div v-else class="relative space-y-8">
                                    <!-- Enhanced Success Icon -->
                                    <div class="relative">
                                        <div class="mx-auto w-32 h-32 rounded-full bg-gradient-to-br from-green-500/30 to-emerald-500/30 border-2 border-green-400/30 flex items-center justify-center shadow-2xl">
                                            <div class="relative">
                                                <CheckCircle class="h-16 w-16 text-green-300" />
                                                <!-- Success Rings -->
                                                <div class="absolute inset-0 w-16 h-16 border-2 border-green-400/40 rounded-full animate-ping"></div>
                                                <div class="absolute inset-0 w-16 h-16 border-2 border-emerald-400/40 rounded-full animate-ping" style="animation-delay: 0.5s"></div>
                                            </div>
                                        </div>

                                        <!-- Success Particles -->
                                        <div class="absolute -top-2 -left-2 w-4 h-4 bg-green-400/60 rounded-full animate-bounce"></div>
                                        <div class="absolute -top-2 -right-2 w-3 h-3 bg-emerald-400/60 rounded-full animate-bounce" style="animation-delay: 0.3s"></div>
                                        <div class="absolute -bottom-2 -left-2 w-3 h-3 bg-green-400/60 rounded-full animate-bounce" style="animation-delay: 0.6s"></div>
                                        <div class="absolute -bottom-2 -right-2 w-4 h-4 bg-emerald-400/60 rounded-full animate-bounce" style="animation-delay: 0.9s"></div>
                                    </div>

                                                                        <div class="space-y-6">
                                        <h3 class="text-3xl font-black text-black">
                                            File Uploaded Successfully!
                                        </h3>
                                        <p class="text-gray-700 text-base max-w-sm mx-auto leading-relaxed font-light">
                                            {{ uploadedFile.name }}
                                        </p>

                                        <!-- Success Badge -->
                                        <div class="inline-flex items-center space-x-2 px-4 py-2 rounded-full bg-green-500/20 border border-green-400/30 backdrop-blur-sm">
                                            <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                                            <span class="text-sm text-black font-medium">Ready for AI Analysis</span>
                                        </div>

                                        <!-- Enhanced Action Buttons -->
                                        <div class="space-y-4 max-w-sm mx-auto">
                                            <Button @click="startChat" class="w-full bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 px-8 py-4 text-black font-semibold rounded-2xl shadow-lg hover:shadow-blue-500/25 transition-all duration-500 transform hover:scale-105 btn-hover-effect">
                                                <MessageCircle class="mr-3 h-5 w-5" />
                                                Start AI Chat
                                            </Button>
                                            <Button @click="removeFile" variant="outline" class="w-full border-white/30 text-black hover:bg-white/10 hover:border-white/50 px-6 py-3 text-sm rounded-2xl backdrop-blur-xl transition-all duration-300">
                                                <X class="mr-3 h-4 w-4" />
                                                Remove File
                                            </Button>
                                        </div>
                                    </div>
                                </div>
                </div>
                        </Label>

                        <input
                            id="pdf-upload"
                            type="file"
                            accept=".pdf"
                            class="hidden"
                            @change="handleFileUpload"
                        />
                    </div>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <section class="relative z-10 mt-20">
            <div class="max-w-7xl mx-auto px-6 py-16">
                <div class="text-center mb-12">
                    <h2 class="text-4xl font-bold text-white mb-4 gradient-text">Advanced Features</h2>
                    <p class="text-xl text-gray-400">Discover the powerful capabilities</p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="p-6 rounded-2xl bg-white/5 backdrop-blur-sm border border-white/10 hover:bg-white/10 transition-all duration-300 feature-card">
                        <div class="mb-6 flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-r from-blue-500/20 to-purple-500/20 border border-blue-400/20 animate-scale">
                            <Brain class="h-8 w-8 text-blue-400" />
                        </div>
                        <h3 class="mb-3 text-xl font-semibold text-white">Advanced AI Intelligence</h3>
                        <p class="text-gray-400 leading-relaxed">Powered by state-of-the-art language models that understand context and provide intelligent responses.</p>
                    </div>

                    <div class="p-6 rounded-2xl bg-white/5 backdrop-blur-sm border border-white/10 hover:bg-white/10 transition-all duration-300 feature-card">
                        <div class="mb-6 flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-r from-purple-500/20 to-pink-500/20 border border-purple-400/20 animate-scale">
                            <MessageCircle class="h-8 w-8 text-purple-400" />
                        </div>
                        <h3 class="mb-3 text-xl font-semibold text-white">Natural Conversation</h3>
                        <p class="text-gray-400 leading-relaxed">Chat naturally with your documents using everyday language and get human-like responses.</p>
                    </div>

                    <div class="p-6 rounded-2xl bg-white/5 backdrop-blur-sm border border-white/10 hover:bg-white/10 transition-all duration-300 feature-card">
                        <div class="mb-6 flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-r from-emerald-500/20 to-teal-500/20 border border-emerald-400/20 animate-scale">
                            <Shield class="h-8 w-8 text-emerald-400" />
                        </div>
                        <h3 class="mb-3 text-xl font-semibold text-white">Enterprise Security</h3>
                        <p class="text-gray-400 leading-relaxed">Your documents are processed securely with enterprise-grade encryption and privacy protection.</p>
                    </div>

                    <div class="p-6 rounded-2xl bg-white/5 backdrop-blur-sm border border-white/10 hover:bg-white/10 transition-all duration-300 feature-card">
                        <div class="mb-6 flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-r from-pink-500/20 to-rose-500/20 border border-pink-400/20 animate-scale">
                            <Zap class="h-8 w-8 text-pink-400" />
                        </div>
                        <h3 class="mb-3 text-xl font-semibold text-white">Lightning Fast</h3>
                        <p class="text-gray-400 leading-relaxed">Get instant responses and insights from your documents in real-time with optimized processing.</p>
                    </div>

                    <div class="p-6 rounded-2xl bg-white/5 backdrop-blur-sm border border-white/10 hover:bg-white/10 transition-all duration-300 feature-card">
                        <div class="mb-6 flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-r from-amber-500/20 to-orange-500/20 border border-amber-400/20 animate-scale">
                            <Infinity class="h-8 w-8 text-amber-400" />
                        </div>
                        <h3 class="mb-3 text-xl font-semibold text-white">Unlimited Possibilities</h3>
                        <p class="text-gray-400 leading-relaxed">From research papers to legal documents, analyze any type of content with our versatile AI.</p>
                    </div>

                    <div class="p-6 rounded-2xl bg-white/5 backdrop-blur-sm border border-white/10 hover:bg-white/10 transition-all duration-300 feature-card">
                        <div class="mb-6 flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-r from-indigo-500/20 to-purple-500/20 border border-indigo-400/20 animate-scale">
                            <Globe class="h-8 w-8 text-indigo-400" />
                        </div>
                        <h3 class="mb-3 text-xl font-semibold text-white">Global Access</h3>
                        <p class="text-gray-400 leading-relaxed">Access your AI-powered documents from anywhere in the world with our cloud-based platform.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- How It Works Section -->
        <section class="relative z-10 mt-20">
            <div class="max-w-7xl mx-auto px-6 py-16">
                <div class="text-center mb-12">
                    <h2 class="text-4xl font-bold text-white mb-4 gradient-text">How It Works</h2>
                    <p class="text-xl text-gray-400">Simple steps to unlock your document intelligence</p>
                </div>

                <div class="grid md:grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Step 1: Upload -->
                    <div class="relative">
                        <div class="p-8 rounded-2xl bg-white/5 backdrop-blur-sm border border-white/10 hover:bg-white/10 transition-all duration-300 feature-card text-center">
                            <div class="mb-6 flex h-20 w-20 items-center justify-center rounded-full bg-gradient-to-r from-blue-500/20 to-purple-500/20 border border-blue-400/20 animate-scale mx-auto">
                                <Upload class="h-10 w-10 text-blue-400" />
                            </div>
                            <div class="mb-4">
                                <span class="inline-flex items-center justify-center w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-600 text-white text-sm font-bold rounded-full">1</span>
                            </div>
                            <h3 class="mb-3 text-xl font-semibold text-white">Upload Your Document</h3>
                            <p class="text-gray-400 leading-relaxed">Simply drag and drop your PDF file or click to browse. Our system supports all major document formats.</p>
                        </div>
                    </div>

                    <!-- Step 2: Process -->
                    <div class="relative">
                        <div class="p-8 rounded-2xl bg-white/5 backdrop-blur-sm border border-white/10 hover:bg-white/10 transition-all duration-300 feature-card text-center">
                            <div class="mb-6 flex h-20 w-20 items-center justify-center rounded-full bg-gradient-to-r from-purple-500/20 to-pink-500/20 border border-purple-400/20 animate-scale mx-auto">
                                <Brain class="h-10 w-10 text-purple-400" />
                            </div>
                            <div class="mb-4">
                                <span class="inline-flex items-center justify-center w-8 h-8 bg-gradient-to-r from-purple-500 to-pink-600 text-white text-sm font-bold rounded-full">2</span>
                            </div>
                            <h3 class="mb-3 text-xl font-semibold text-white">AI Processing</h3>
                            <p class="text-gray-400 leading-relaxed">Our advanced AI analyzes your document, extracts key information, and prepares it for intelligent conversation.</p>
                        </div>
                    </div>

                    <!-- Step 3: Chat -->
                    <div class="relative">
                        <div class="p-8 rounded-2xl bg-white/5 backdrop-blur-sm border border-white/10 hover:bg-white/10 transition-all duration-300 feature-card text-center">
                            <div class="mb-6 flex h-20 w-20 items-center justify-center rounded-full bg-gradient-to-r from-pink-500/20 to-rose-500/20 border border-pink-400/20 animate-scale mx-auto">
                                <MessageCircle class="h-10 w-10 text-pink-400" />
                            </div>
                            <div class="mb-4">
                                <span class="inline-flex items-center justify-center w-8 h-8 bg-gradient-to-r from-pink-500 to-rose-600 text-white text-sm font-bold rounded-full">3</span>
                            </div>
                            <h3 class="mb-3 text-xl font-semibold text-white">Start Chatting</h3>
                            <p class="text-gray-400 leading-relaxed">Ask questions, get insights, and explore your document through natural conversation with our AI assistant.</p>
                        </div>
                    </div>
                </div>

                <!-- Connection Lines -->
                <div class="hidden lg:block relative mt-8">
                    <div class="absolute top-1/2 left-1/4 w-1/2 h-0.5 bg-gradient-to-r from-blue-500/30 to-purple-500/30 transform -translate-y-1/2"></div>
                    <div class="absolute top-1/2 left-3/4 w-1/2 h-0.5 bg-gradient-to-r from-purple-500/30 to-pink-500/30 transform -translate-y-1/2"></div>
                </div>
            </div>
        </section>

        <!-- What People Say on X Section -->
        <section class="relative z-10 mt-20 overflow-hidden">
            <div class="max-w-7xl mx-auto px-6 py-16">
                <div class="text-center mb-12">
                    <h2 class="text-4xl font-bold text-white mb-4 gradient-text">What People Say on X</h2>
                    <p class="text-xl text-gray-400">Real feedback from our community</p>
                </div>

                <!-- Scrolling Testimonials Container -->
                <div class="relative">
                    <!-- First Row -->
                    <div class="flex space-x-6 animate-scroll-left">
                        <!-- Testimonial 1 -->
                        <div class="flex-shrink-0 w-80 p-6 rounded-2xl bg-white/5 backdrop-blur-sm border border-white/10 hover:bg-white/10 transition-all duration-300">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-white text-sm font-bold">S</span>
                                </div>
                                <div>
                                    <h4 class="text-white font-semibold">Sarah Chen</h4>
                                    <p class="text-gray-400 text-sm">@sarah_ai</p>
                                </div>
                            </div>
                            <p class="text-gray-300 text-sm leading-relaxed">"This AI document chat is incredible! I can now understand complex research papers in minutes. Game changer for my PhD work! 🚀"</p>
                            <div class="flex items-center mt-4 text-gray-500 text-xs">
                                <span>2 hours ago</span>
                                <span class="mx-2">•</span>
                                <span>❤️ 24</span>
                                <span class="mx-2">•</span>
                                <span>🔄 8</span>
                            </div>
                        </div>

                        <!-- Testimonial 2 -->
                        <div class="flex-shrink-0 w-80 p-6 rounded-2xl bg-white/5 backdrop-blur-sm border border-white/10 hover:bg-white/10 transition-all duration-300">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-600 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-white text-sm font-bold">M</span>
                                </div>
                                <div>
                                    <h4 class="text-white font-semibold">Mike Rodriguez</h4>
                                    <p class="text-gray-400 text-sm">@mike_dev</p>
                                </div>
                            </div>
                            <p class="text-gray-300 text-sm leading-relaxed">"As a developer, this tool saves me hours of reading through documentation. The AI understands context perfectly! 💻✨"</p>
                            <div class="flex items-center mt-4 text-gray-500 text-xs">
                                <span>5 hours ago</span>
                                <span class="mx-2">•</span>
                                <span>❤️ 42</span>
                                <span class="mx-2">•</span>
                                <span>🔄 15</span>
                            </div>
                        </div>

                        <!-- Testimonial 3 -->
                        <div class="flex-shrink-0 w-80 p-6 rounded-2xl bg-white/5 backdrop-blur-sm border border-white/10 hover:bg-white/10 transition-all duration-300">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-gradient-to-r from-pink-500 to-rose-600 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-white text-sm font-bold">A</span>
                                </div>
                                <div>
                                    <h4 class="text-white font-semibold">Alex Thompson</h4>
                                    <p class="text-gray-400 text-sm">@alex_legal</p>
                                </div>
                            </div>
                            <p class="text-gray-300 text-sm leading-relaxed">"Legal document analysis has never been easier. This AI catches details I might miss. Essential for my practice! ⚖️📄"</p>
                            <div class="flex items-center mt-4 text-gray-500 text-xs">
                                <span>1 day ago</span>
                                <span class="mx-2">•</span>
                                <span>❤️ 67</span>
                                <span class="mx-2">•</span>
                                <span>🔄 23</span>
                            </div>
                        </div>

                        <!-- Testimonial 4 -->
                        <div class="flex-shrink-0 w-80 p-6 rounded-2xl bg-white/5 backdrop-blur-sm border border-white/10 hover:bg-white/10 transition-all duration-300">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-gradient-to-r from-emerald-500 to-teal-600 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-white text-sm font-bold">E</span>
                                </div>
                                <div>
                                    <h4 class="text-white font-semibold">Emma Wilson</h4>
                                    <p class="text-gray-400 text-sm">@emma_research</p>
                                </div>
                            </div>
                            <p class="text-gray-300 text-sm leading-relaxed">"Research papers are now a breeze! I can ask questions and get instant insights. This is the future of academic reading! 🎓📚"</p>
                            <div class="flex items-center mt-4 text-gray-500 text-xs">
                                <span>2 days ago</span>
                                <span class="mx-2">•</span>
                                <span>❤️ 89</span>
                                <span class="mx-2">•</span>
                                <span>🔄 31</span>
                            </div>
                        </div>

                        <!-- Testimonial 5 -->
                        <div class="flex-shrink-0 w-80 p-6 rounded-2xl bg-white/5 backdrop-blur-sm border border-white/10 hover:bg-white/10 transition-all duration-300">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-gradient-to-r from-amber-500 to-orange-600 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-white text-sm font-bold">D</span>
                                </div>
                                <div>
                                    <h4 class="text-white font-semibold">David Kim</h4>
                                    <p class="text-gray-400 text-sm">@david_business</p>
                                </div>
                            </div>
                            <p class="text-gray-300 text-sm leading-relaxed">"Business reports analysis in seconds! This tool gives me insights I never had before. ROI is incredible! 📊💼"</p>
                            <div class="flex items-center mt-4 text-gray-500 text-xs">
                                <span>3 days ago</span>
                                <span class="mx-2">•</span>
                                <span>❤️ 156</span>
                                <span class="mx-2">•</span>
                                <span>🔄 47</span>
                            </div>
                        </div>
                    </div>

                    <!-- Second Row (Moving in opposite direction) -->
                    <div class="flex space-x-6 mt-6 animate-scroll-right">
                        <!-- Testimonial 6 -->
                        <div class="flex-shrink-0 w-80 p-6 rounded-2xl bg-white/5 backdrop-blur-sm border border-white/10 hover:bg-white/10 transition-all duration-300">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-white text-sm font-bold">L</span>
                                </div>
                                <div>
                                    <h4 class="text-white font-semibold">Lisa Park</h4>
                                    <p class="text-gray-400 text-sm">@lisa_tech</p>
                                </div>
                            </div>
                            <p class="text-gray-300 text-sm leading-relaxed">"Technical documentation is now interactive! I can ask questions and get instant answers. This is revolutionary! 🔧⚡"</p>
                            <div class="flex items-center mt-4 text-gray-500 text-xs">
                                <span>4 days ago</span>
                                <span class="mx-2">•</span>
                                <span>❤️ 203</span>
                                <span class="mx-2">•</span>
                                <span>🔄 78</span>
                            </div>
                        </div>

                        <!-- Testimonial 7 -->
                        <div class="flex-shrink-0 w-80 p-6 rounded-2xl bg-white/5 backdrop-blur-sm border border-white/10 hover:bg-white/10 transition-all duration-300">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-gradient-to-r from-rose-500 to-pink-600 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-white text-sm font-bold">J</span>
                                </div>
                                <div>
                                    <h4 class="text-white font-semibold">James Miller</h4>
                                    <p class="text-gray-400 text-sm">@james_writer</p>
                                </div>
                            </div>
                            <p class="text-gray-300 text-sm leading-relaxed">"As a content writer, this helps me research topics faster than ever. The AI summaries are spot-on! ✍️📝"</p>
                            <div class="flex items-center mt-4 text-gray-500 text-xs">
                                <span>5 days ago</span>
                                <span class="mx-2">•</span>
                                <span>❤️ 134</span>
                                <span class="mx-2">•</span>
                                <span>🔄 52</span>
                            </div>
                        </div>

                        <!-- Testimonial 8 -->
                        <div class="flex-shrink-0 w-80 p-6 rounded-2xl bg-white/5 backdrop-blur-sm border border-white/10 hover:bg-white/10 transition-all duration-300">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-gradient-to-r from-teal-500 to-emerald-600 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-white text-sm font-bold">N</span>
                                </div>
                                <div>
                                    <h4 class="text-white font-semibold">Nina Patel</h4>
                                    <p class="text-gray-400 text-sm">@nina_analyst</p>
                                </div>
                            </div>
                            <p class="text-gray-300 text-sm leading-relaxed">"Data analysis reports are now interactive! I can ask follow-up questions and get deeper insights. Amazing tool! 📈🔍"</p>
                            <div class="flex items-center mt-4 text-gray-500 text-xs">
                                <span>1 week ago</span>
                                <span class="mx-2">•</span>
                                <span>❤️ 287</span>
                                <span class="mx-2">•</span>
                                <span>🔄 94</span>
                            </div>
                        </div>

                        <!-- Testimonial 9 -->
                        <div class="flex-shrink-0 w-80 p-6 rounded-2xl bg-white/5 backdrop-blur-sm border border-white/10 hover:bg-white/10 transition-all duration-300">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-gradient-to-r from-orange-500 to-amber-600 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-white text-sm font-bold">R</span>
                                </div>
                                <div>
                                    <h4 class="text-white font-semibold">Ryan Chen</h4>
                                    <p class="text-gray-400 text-sm">@ryan_consultant</p>
                                </div>
                            </div>
                            <p class="text-gray-300 text-sm leading-relaxed">"Consulting reports analysis is now lightning fast! This AI understands business context perfectly! 💼🚀"</p>
                            <div class="flex items-center mt-4 text-gray-500 text-xs">
                                <span>1 week ago</span>
                                <span class="mx-2">•</span>
                                <span>❤️ 198</span>
                                <span class="mx-2">•</span>
                                <span>🔄 67</span>
                            </div>
                        </div>

                        <!-- Testimonial 10 -->
                        <div class="flex-shrink-0 w-80 p-6 rounded-2xl bg-white/5 backdrop-blur-sm border border-white/10 hover:bg-white/10 transition-all duration-300">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-indigo-600 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-white text-sm font-bold">S</span>
                                </div>
                                <div>
                                    <h4 class="text-white font-semibold">Sophie Brown</h4>
                                    <p class="text-gray-400 text-sm">@sophie_educator</p>
                                </div>
                            </div>
                            <p class="text-gray-300 text-sm leading-relaxed">"Teaching materials are now interactive! Students can ask questions about any document. This is education 2.0! 🎓✨"</p>
                            <div class="flex items-center mt-4 text-gray-500 text-xs">
                                <span>2 weeks ago</span>
                                <span class="mx-2">•</span>
                                <span>❤️ 342</span>
                                <span class="mx-2">•</span>
                                <span>🔄 128</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- How This Chat Bot Can Help You Section -->
        <section class="relative z-10 mt-20">
            <div class="max-w-7xl mx-auto px-6 py-16">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-bold text-white mb-4 gradient-text">How This Chat Bot Can Help You</h2>
                    <p class="text-xl text-gray-400">Transform your documents into interactive, intelligent conversations</p>
                </div>

                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <!-- Left Side - Main Content -->
                    <div class="space-y-8">
                        <div class="p-8 rounded-3xl bg-gradient-to-br from-blue-600/10 to-purple-600/10 border border-blue-500/20 backdrop-blur-sm">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center mr-4">
                                    <FileText class="h-6 w-6 text-white" />
                                </div>
                                <h3 class="text-2xl font-bold text-white">Scientific Research</h3>
                            </div>
                            <p class="text-gray-300 leading-relaxed text-lg">
                                Dive deep into complex research papers, academic journals, and scientific literature.
                                Ask questions about methodologies, results, and conclusions. Get instant insights
                                that would take hours of manual reading.
                            </p>
                        </div>

                        <div class="p-8 rounded-3xl bg-gradient-to-br from-purple-600/10 to-pink-600/10 border border-purple-500/20 backdrop-blur-sm">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center mr-4">
                                    <BookOpen class="h-6 w-6 text-white" />
                                </div>
                                <h3 class="text-2xl font-bold text-white">Books & Literature</h3>
                            </div>
                            <p class="text-gray-300 leading-relaxed text-lg">
                                Transform any book into an interactive learning experience. Discuss characters,
                                analyze themes, explore plot developments, and get detailed explanations of
                                complex passages. Your personal literary companion.
                            </p>
                        </div>

                        <div class="p-8 rounded-3xl bg-gradient-to-br from-pink-600/10 to-rose-600/10 border border-pink-500/20 backdrop-blur-sm">
                            <div class="flex items-center mb-4">
                                <div class="w-12 h-12 bg-gradient-to-r from-pink-500 to-rose-600 rounded-2xl flex items-center justify-center mr-4">
                                    <Users class="h-6 w-6 text-white" />
                                </div>
                                <h3 class="text-2xl font-bold text-white">Character Conversations</h3>
                            </div>
                            <p class="text-gray-300 leading-relaxed text-lg">
                                Chat with historical figures, fictional characters, or create your own custom
                                personas. Have meaningful conversations, ask for advice, or explore different
                                perspectives. Your imagination is the only limit.
                            </p>
                        </div>
                    </div>

                    <!-- Right Side - Additional Features -->
                    <div class="space-y-6">
                        <div class="p-6 rounded-2xl bg-white/5 backdrop-blur-sm border border-white/10 hover:bg-white/10 transition-all duration-300">
                            <div class="flex items-center mb-3">
                                <div class="w-10 h-10 bg-gradient-to-r from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center mr-3">
                                    <TrendingUp class="h-5 w-5 text-white" />
                                </div>
                                <h4 class="text-white font-semibold text-lg">Sales & Marketing</h4>
                            </div>
                            <p class="text-gray-400 leading-relaxed">
                                Analyze sales reports, marketing strategies, and customer data. Get insights
                                on performance metrics, identify opportunities, and optimize your business approach.
                            </p>
                        </div>

                        <div class="p-6 rounded-2xl bg-white/5 backdrop-blur-sm border border-white/10 hover:bg-white/10 transition-all duration-300">
                            <div class="flex items-center mb-3">
                                <div class="w-10 h-10 bg-gradient-to-r from-amber-500 to-orange-600 rounded-xl flex items-center justify-center mr-3">
                                    <BarChart3 class="h-5 w-5 text-white" />
                                </div>
                                <h4 class="text-white font-semibold text-lg">Data Analysis</h4>
                            </div>
                            <p class="text-gray-400 leading-relaxed">
                                Transform complex data reports into actionable insights. Ask questions about
                                trends, patterns, and correlations. Get instant analysis and recommendations.
                            </p>
                        </div>

                        <div class="p-6 rounded-2xl bg-white/5 backdrop-blur-sm border border-white/10 hover:bg-white/10 transition-all duration-300">
                            <div class="flex items-center mb-3">
                                <div class="w-10 h-10 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center mr-3">
                                    <Lightbulb class="h-5 w-5 text-white" />
                                </div>
                                <h4 class="text-white font-semibold text-lg">Creative Writing</h4>
                            </div>
                            <p class="text-gray-400 leading-relaxed">
                                Brainstorm ideas, develop characters, and refine your writing. Get feedback,
                                suggestions, and creative inspiration for your next masterpiece.
                            </p>
                        </div>

                        <div class="p-6 rounded-2xl bg-white/5 backdrop-blur-sm border border-white/10 hover:bg-white/10 transition-all duration-300">
                            <div class="flex items-center mb-3">
                                <div class="w-10 h-10 bg-gradient-to-r from-rose-500 to-pink-600 rounded-xl flex items-center justify-center mr-3">
                                    <GraduationCap class="h-5 w-5 text-white" />
                                </div>
                                <h4 class="text-white font-semibold text-lg">Education & Learning</h4>
                            </div>
                            <p class="text-gray-400 leading-relaxed">
                                Study any subject with an AI tutor. Ask questions, get explanations, practice
                                problems, and accelerate your learning journey across any discipline.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Bottom CTA -->
                <div class="text-center mt-16">
                    <div class="inline-flex items-center space-x-4 p-6 rounded-2xl bg-gradient-to-r from-blue-600/10 to-purple-600/10 border border-blue-500/20">
                        <Sparkles class="h-8 w-8 text-blue-400" />
                        <div class="text-left">
                            <h3 class="text-xl font-bold text-white">Ready to Experience the Future?</h3>
                            <p class="text-gray-400">Start chatting with your documents today</p>
                        </div>
                        <Button class="bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 px-6 py-3 rounded-xl">
                            Get Started Now
                        </Button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Pricing Plans Section -->
        <section class="relative z-10 mt-16 sm:mt-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 py-12 sm:py-16">
                <div class="text-center mb-12 sm:mb-16">
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-white mb-4 gradient-text">Choose Your Plan</h2>
                    <p class="text-base sm:text-lg lg:text-xl text-gray-400">Start free and scale as you grow</p>
                </div>

                <div class="grid md:grid-cols-2 xl:grid-cols-4 gap-10 sm:gap-12 lg:gap-16 max-w-8xl mx-auto">
                    <template v-for="(plan, index) in props.plans" :key="plan.id">
                        <div class="relative p-10 sm:p-12 rounded-3xl bg-white/5 backdrop-blur-sm border border-white/10 hover:bg-white/10 transition-all duration-300 transform hover:scale-105 min-w-0 flex flex-col">
                            <!-- Popular Badge for second plan -->
                            <div v-if="index === 1" class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                                <div class="bg-gradient-to-r from-blue-500 to-purple-600 text-white px-4 py-2 rounded-full text-sm font-semibold">
                                    Most Popular
                                </div>
                            </div>

                            <div class="text-center mb-8">
                                <div class="w-16 h-16 bg-gradient-to-r from-gray-500 to-gray-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                    <Users v-if="index === 0" class="h-8 w-8 text-white" />
                                    <Star v-else-if="index === 1" class="h-8 w-8 text-white" />
                                    <Crown v-else-if="index === 2" class="h-8 w-8 text-white" />
                                    <Zap v-else class="h-8 w-8 text-white" />
                                </div>
                                <h3 class="text-2xl font-bold text-white mb-2">{{ plan.name }}</h3>
                                <div v-if="plan.name !== 'Enterprice'" class="text-4xl font-bold text-white mb-2">${{ plan.price }}</div>
                                <div v-else class="text-4xl font-bold text-white mb-2">Let's Talk</div>
                                <p class="text-gray-400">{{ plan.description || 'Perfect for getting started' }}</p>
                            </div>

                            <ul class="space-y-4 mb-8 flex-1">
                                <li v-for="feature in (plan.features || [])" :key="feature" class="flex items-center text-gray-300">
                                    <CheckCircle class="h-5 w-5 text-green-400 mr-3 flex-shrink-0" />
                                    <span>{{ feature }}</span>
                                </li>
                            </ul>

                            <Button @click="startFreeChat" class="w-full bg-white/10 hover:bg-white/20 text-white border border-white/20 py-3 rounded-xl transition-all duration-300 mt-auto">
                                Choose Plan
                            </Button>
                        </div>
                    </template>
                </div>

                <!-- Additional Info -->
                <div class="text-center mt-12">
                    <p class="text-gray-400 mb-6">All plans include a 14-day free trial. No credit card required.</p>
                    <div class="flex flex-wrap justify-center gap-6 text-sm text-gray-400">
                        <div class="flex items-center">
                            <Shield class="h-4 w-4 text-green-400 mr-2" />
                            <span>Enterprise-grade security</span>
                        </div>
                        <div class="flex items-center">
                            <Zap class="h-4 w-4 text-blue-400 mr-2" />
                            <span>99.9% uptime guarantee</span>
                        </div>
                        <div class="flex items-center">
                            <Globe class="h-4 w-4 text-purple-400 mr-2" />
                            <span>Global data centers</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="relative z-10 mt-20 border-t border-white/10">
            <div class="max-w-7xl mx-auto px-6 py-24">
                <div class="text-center">
                    <h2 class="text-4xl font-bold text-white sm:text-5xl mb-6 gradient-text">
                        Ready to transform your document experience?
                    </h2>
                    <p class="text-xl text-gray-300 mb-12 max-w-3xl mx-auto">
                        Join thousands of professionals who are already leveraging AI to unlock insights from their documents.
                    </p>
                    <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-6">
                        <Link href="/admin/register">
                            <Button size="lg" class="bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 px-10 py-5 text-lg rounded-2xl shadow-2xl hover:shadow-blue-500/25 transform hover:scale-105 transition-all duration-300 btn-hover-effect">
                                Start Free Trial
                                <ArrowRight class="ml-3 h-5 w-5" />
                            </Button>
                        </Link>
                        <Link href="/admin/login">
                            <Button size="lg" variant="outline" class="border-white/20 text-white hover:bg-white/10 px-10 py-5 text-lg rounded-2xl backdrop-blur-sm">
                                Sign In
                            </Button>
                        </Link>
                    </div>
                </div>
            </div>
        </section>

                <!-- Plans Selection Interface -->
        <div v-if="showPlans" class="fixed inset-0 z-50 flex items-end justify-center p-2 sm:p-4 sm:items-center">
            <div class="fixed inset-0 bg-black/80 backdrop-blur-sm" @click="closePlans"></div>
            <Card class="relative w-full max-w-7xl lg:max-w-8xl bg-black/90 border border-white/20 backdrop-blur-xl">
                <CardHeader class="border-b border-white/10 bg-white/5 p-4 sm:p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2 sm:space-x-4">
                            <div class="flex h-8 w-8 sm:h-12 sm:w-12 items-center justify-center rounded-full bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500">
                                <Sparkles class="h-4 w-4 sm:h-6 sm:w-6 text-white" />
                            </div>
                            <div>
                                <CardTitle class="text-lg sm:text-xl lg:text-2xl text-white">Choose Your Plan</CardTitle>
                                <CardDescription class="text-xs sm:text-sm text-gray-400">Select the perfect plan to start your AI journey</CardDescription>
                            </div>
                        </div>
                        <Button variant="ghost" size="sm" @click="closePlans" class="text-gray-400 hover:text-white hover:bg-white/10">
                            <X class="h-4 w-4 sm:h-6 sm:w-6" />
                        </Button>
                    </div>
                </CardHeader>

                <CardContent class="p-4 sm:p-6 lg:p-8">
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-8 sm:gap-10 lg:gap-12">
                        <template v-for="(plan, index) in props.plans" :key="plan.id">
                            <div class="group relative p-10 sm:p-12 rounded-3xl bg-gradient-to-br from-white/10 via-white/5 to-white/10 backdrop-blur-sm border border-white/20 hover:border-blue-500/50 transition-all duration-500 hover:scale-105 hover-lift min-w-0 flex flex-col">
                                <div class="absolute -inset-2 bg-gradient-to-r from-blue-500/20 via-purple-500/20 to-pink-500/20 rounded-3xl blur-xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

                                <div class="relative space-y-6">
                                    <!-- Popular Badge for second plan -->
                                    <div v-if="index === 1" class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                                        <div class="px-4 py-2 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full text-white text-sm font-semibold shadow-lg">
                                            Most Popular
                                        </div>
                                    </div>

                                    <!-- Plan Header -->
                                    <div class="text-center">
                                        <div class="mx-auto w-16 h-16 rounded-full bg-gradient-to-br from-blue-500/30 to-purple-500/30 border border-blue-400/20 flex items-center justify-center mb-4">
                                            <Zap v-if="index === 0" class="h-8 w-8 text-blue-400" />
                                            <Star v-else-if="index === 1" class="h-8 w-8 text-purple-400" />
                                            <Crown v-else-if="index === 2" class="h-8 w-8 text-emerald-400" />
                                            <Users v-else class="h-8 w-8 text-pink-400" />
                                        </div>
                                        <h3 class="text-2xl font-bold text-white mb-2">{{ plan.name }}</h3>
                                        <div v-if="plan.name !== 'Enterprice'" class="text-4xl font-black text-white mb-2">${{ plan.price }}</div>
                                        <div v-else class="text-4xl font-black text-white mb-2">Let's Talk</div>
                                        <p class="text-gray-400 text-sm">{{ plan.description || 'Perfect for getting started' }}</p>
                                    </div>

                                    <!-- Features -->
                                    <div class="space-y-3 flex-1">
                                        <div v-for="feature in (plan.features || [])" :key="feature" class="flex items-center space-x-3">
                                            <CheckCircle class="h-5 w-5 text-green-400" />
                                            <span class="text-white text-sm">{{ feature }}</span>
                                        </div>
                                    </div>

                                    <!-- CTA Button -->
                                    <Button @click="startFreeChat" class="w-full bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 px-6 py-3 text-white font-semibold rounded-2xl shadow-lg hover:shadow-blue-500/25 transition-all duration-300 transform hover:scale-105 mt-auto">
                                        Choose Plan
                                    </Button>
                                </div>
                            </div>
                        </template>
                    </div>
                </CardContent>
            </Card>
        </div>

        <!-- Footer -->
        <footer class="relative z-10 mt-20 border-t border-white/10 bg-gradient-to-br from-gray-900/50 to-black/50 backdrop-blur-sm">
            <div class="max-w-7xl mx-auto px-6 py-16">
                <!-- Main Footer Content -->
                <div class="grid lg:grid-cols-4 md:grid-cols-2 gap-8 mb-12">
                    <!-- Company Info -->
                    <div class="lg:col-span-1">
                        <div class="flex items-center space-x-3 mb-6">
                            <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl flex items-center justify-center">
                                <MessageCircle class="h-6 w-6 text-white" />
                            </div>
                            <h3 class="text-2xl font-bold text-white">ChatMe</h3>
                        </div>
                        <p class="text-gray-400 leading-relaxed mb-6">
                            Transform your documents into intelligent conversations with cutting-edge AI technology.
                            Unlock insights, ask questions, and discover knowledge like never before.
                        </p>
                        <div class="flex space-x-4">
                            <a href="#" class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center hover:bg-white/20 transition-colors">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                    </svg>
                            </a>
                            <a href="#" class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center hover:bg-white/20 transition-colors">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/>
                    </svg>
                            </a>
                            <a href="#" class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center hover:bg-white/20 transition-colors">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                    </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Product -->
                    <div>
                        <h4 class="text-white font-semibold text-lg mb-6">Product</h4>
                        <ul class="space-y-3">
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Features</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Pricing</a></li>
                        </ul>
                    </div>

                    <!-- Company -->
                    <div>
                        <h4 class="text-white font-semibold text-lg mb-6">Company</h4>
                        <ul class="space-y-3">
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">About</a></li>

                        </ul>
                    </div>

                    <!-- Support -->
                    <div>
                        <h4 class="text-white font-semibold text-lg mb-6">Support</h4>
                        <ul class="space-y-3">
                            <li><a href="/help-center" class="text-gray-400 hover:text-white transition-colors">Help Center</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Contact Us</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Privacy Policy</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Newsletter Subscription -->
                <div class="border-t border-white/10 pt-8 mb-8">
                    <div class="max-w-2xl mx-auto text-center">
                        <h4 class="text-white font-semibold text-lg mb-3">Stay Updated</h4>
                        <p class="text-gray-400 mb-6">Get the latest updates on new features and AI advancements</p>
                        <div class="flex flex-col sm:flex-row gap-3 max-w-md mx-auto">
                            <Input
                                type="email"
                                placeholder="Enter your email"
                                class="flex-1 bg-white/10 border-white/20 text-white placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500"
                            />
                            <Button class="bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 px-6">
                                Subscribe
                            </Button>
                </div>
        </div>
                </div>

                <!-- Bottom Footer -->
                <div class="border-t border-white/10 pt-8">
                    <div class="flex flex-col md:flex-row justify-between items-center">
                        <div class="text-gray-400 text-sm mb-4 md:mb-0">
                            © 2024 ChatMe. All rights reserved. Made with ❤️ for the AI community.
                        </div>
                        <div class="flex items-center space-x-6 text-sm">
                            <a href="#" class="text-gray-400 hover:text-white transition-colors">Terms of Service</a>
                            <a href="#" class="text-gray-400 hover:text-white transition-colors">Privacy Policy</a>
                            <a href="#" class="text-gray-400 hover:text-white transition-colors">Cookie Policy</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Floating Elements -->
            <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
                <div class="absolute top-20 left-10 w-2 h-2 bg-blue-500 rounded-full animate-pulse opacity-60"></div>
                <div class="absolute top-40 right-20 w-1 h-1 bg-purple-500 rounded-full animate-ping opacity-40"></div>
                <div class="absolute bottom-20 left-1/4 w-1.5 h-1.5 bg-pink-500 rounded-full animate-bounce opacity-50"></div>
                <div class="absolute bottom-40 right-1/3 w-1 h-1 bg-emerald-500 rounded-full animate-bounce opacity-30"></div>
            </div>
        </footer>

                <!-- Auth Modal -->
        <div v-if="showLoginModal || showSignupModal" class="fixed inset-0 z-[100] flex items-center justify-center p-4">
            <!-- Backdrop -->
            <div class="absolute inset-0 bg-black/80 backdrop-blur-xl" @click="closeAuthModal"></div>

            <!-- Modal Content -->
            <div class="relative w-full max-w-sm sm:max-w-md transform overflow-hidden rounded-2xl sm:rounded-3xl bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 p-4 sm:p-6 lg:p-8 shadow-2xl border border-white/10 transition-all duration-500">
                <!-- Floating Elements -->
                <div class="absolute top-4 right-4 w-16 h-16 bg-gradient-to-br from-blue-500/20 to-purple-500/20 rounded-full blur-2xl"></div>
                <div class="absolute bottom-4 left-4 w-12 h-12 bg-gradient-to-br from-pink-500/20 to-rose-500/20 rounded-full blur-xl"></div>

                <!-- Header -->
                <div class="text-center mb-6 sm:mb-8">
                    <div class="flex h-12 w-12 sm:h-16 sm:w-16 items-center justify-center rounded-2xl bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 p-0.5 mx-auto mb-3 sm:mb-4">
                        <div class="flex h-full w-full items-center justify-center rounded-2xl bg-gray-900">
                            <Bot class="h-6 w-6 sm:h-8 sm:w-8 text-white" />
                        </div>
                    </div>
                    <h2 class="text-xl sm:text-2xl font-bold text-white mb-2">
                        {{ isLoginMode ? 'Welcome Back' : 'Create Account' }}
                    </h2>
                    <p class="text-sm sm:text-base text-gray-400">
                        {{ isLoginMode ? 'Sign in to your account' : 'Join our AI platform today' }}
                    </p>
                </div>

                <!-- Form -->
                <form @submit.prevent="isLoginMode ? handleLogin : handleSignup" class="space-y-4 sm:space-y-6">
                    <!-- Name Field (Signup Only) -->
                    <div v-if="!isLoginMode" class="space-y-2">
                        <label class="block text-xs sm:text-sm font-medium text-gray-300">Full Name</label>
                        <input
                            v-model="signupForm.name"
                            type="text"
                            required
                            class="w-full px-3 sm:px-4 py-2.5 sm:py-3 bg-gray-800 border border-gray-600 rounded-xl text-white placeholder-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:outline-none transition-all duration-300 text-sm sm:text-base"
                            placeholder="Enter your full name"
                        />
                    </div>

                    <!-- Email Field -->
                    <div class="space-y-2">
                        <label class="block text-xs sm:text-sm font-medium text-gray-300">Email Address</label>
                        <input
                            v-model="emailValue"
                            type="email"
                            required
                            class="w-full px-3 sm:px-4 py-2.5 sm:py-3 bg-gray-800 border border-gray-600 rounded-xl text-white placeholder-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:outline-none transition-all duration-300 text-sm sm:text-base"
                            placeholder="Enter your email"
                        />
                    </div>

                    <!-- Password Field -->
                    <div class="space-y-2">
                        <label class="block text-xs sm:text-sm font-medium text-gray-300">Password</label>
                        <input
                            v-model="passwordValue"
                            type="password"
                            required
                            class="w-full px-3 sm:px-4 py-2.5 sm:py-3 bg-gray-800 border border-gray-600 rounded-xl text-white placeholder-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:outline-none transition-all duration-300 text-sm sm:text-base"
                            placeholder="Enter your password"
                        />
                    </div>

                    <!-- Confirm Password Field (Signup Only) -->
                    <div v-if="!isLoginMode" class="space-y-2">
                        <label class="block text-xs sm:text-sm font-medium text-gray-300">Confirm Password</label>
                        <input
                            v-model="signupForm.confirmPassword"
                            type="password"
                            required
                            class="w-full px-3 sm:px-4 py-2.5 sm:py-3 bg-gray-800 border border-gray-600 rounded-xl text-white placeholder-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:outline-none transition-all duration-300 text-sm sm:text-base"
                            placeholder="Confirm your password"
                        />
                    </div>

                    <!-- Divider -->
                    <div class="relative my-4 sm:my-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-600"></div>
                        </div>
                        <div class="relative flex justify-center text-xs sm:text-sm">
                            <span class="px-3 sm:px-4 bg-gray-900 text-gray-400">or continue with</span>
                        </div>
                    </div>

                    <!-- Google Auth Button -->
                    <button
                        type="button"
                        @click="handleGoogleAuth"
                        :disabled="isSubmitting"
                        class="group w-full bg-white hover:bg-gray-50 text-gray-800 font-semibold py-3.5 rounded-xl border border-gray-300 hover:border-gray-400 shadow-lg hover:shadow-xl hover:shadow-gray-500/20 transform hover:scale-[1.02] hover:-translate-y-0.5 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none disabled:hover:shadow-lg flex items-center justify-center space-x-3 relative overflow-hidden"
                    >
                        <!-- Hover Effect Background -->
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-50 to-purple-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                        <!-- Google Icon -->
                        <div class="relative flex items-center justify-center">
                            <svg class="w-5 h-5" viewBox="0 0 24 24">
                                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                            </svg>
                        </div>

                        <!-- Button Text -->
                        <span class="relative font-medium">
                            <span v-if="isSubmitting" class="flex items-center">
                                <div class="w-4 h-4 border-2 border-gray-600 border-t-transparent rounded-full animate-spin mr-2"></div>
                                Signing in...
                            </span>
                            <span v-else>Continue with Google</span>
                        </span>

                        <!-- Arrow Icon -->
                        <div class="relative w-5 h-5 text-gray-600 group-hover:text-gray-800 transition-colors duration-300">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </button>

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        :disabled="isSubmitting"
                        class="w-full bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-semibold py-3 rounded-xl shadow-lg hover:shadow-blue-500/25 transform hover:scale-105 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
                    >
                        <span v-if="isSubmitting" class="flex items-center justify-center">
                            <div class="w-5 h-5 border-2 border-white/30 border-t-white rounded-full animate-spin mr-2"></div>
                            {{ isLoginMode ? 'Signing In...' : 'Creating Account...' }}
                        </span>
                        <span v-else>
                            {{ isLoginMode ? 'Sign In' : 'Create Account' }}
                        </span>
                    </button>
                </form>

                <!-- Toggle Mode -->
                <div class="text-center mt-6">
                    <p class="text-gray-400">
                        {{ isLoginMode ? "Don't have an account?" : "Already have an account?" }}
                        <button
                            @click="toggleAuthMode"
                            class="text-blue-400 hover:text-blue-300 font-medium transition-colors duration-300"
                        >
                            {{ isLoginMode ? 'Sign up' : 'Sign in' }}
                        </button>
                    </p>
                </div>

                <!-- Close Button -->
                <button
                    @click="closeAuthModal"
                    class="absolute top-4 right-4 p-2 text-gray-400 hover:text-white hover:bg-gray-800 rounded-xl transition-all duration-300"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

    </div>
</template>

<style scoped>
/* Floating animations */
.animate-float {
    animation: float 3s ease-in-out infinite;
}

@keyframes float {
    0%, 100% {
        transform: translateY(0px);
    }
    50% {
        transform: translateY(-10px);
    }
}

/* Scale animations */
@keyframes scale {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.1);
    }
}

.animate-scale {
    animation: scale 2s ease-in-out infinite;
}

/* Shimmer effect */
.shimmer {
    background: linear-gradient(
        90deg,
        transparent,
        rgba(255, 255, 255, 0.1),
        transparent
    );
    background-size: 200% 100%;
    animation: shimmer 2s infinite;
}

@keyframes shimmer {
    0% {
        background-position: -200% 0;
    }
    100% {
        background-position: 200% 0;
    }
}

/* Gradient text animation */
.gradient-text {
    background: linear-gradient(45deg, #8b5cf6, #ec4899, #3b82f6);
    background-size: 200% 200%;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    animation: gradient-shift 3s ease infinite;
}

@keyframes gradient-shift {
    0%, 100% {
        background-position: 0% 50%;
    }
    50% {
        background-position: 100% 50%;
    }
}

/* Hover animations for cards */
.feature-card {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.feature-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 25px 50px -12px rgba(139, 92, 246, 0.25);
}

/* Button hover effects */
.btn-hover-effect {
    position: relative;
    overflow: hidden;
}

.btn-hover-effect::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s;
}

.btn-hover-effect:hover::before {
    left: 100%;
}

/* Scrolling animations */
@keyframes scroll-left {
    0% {
        transform: translateX(0);
    }
    100% {
        transform: translateX(-100%);
    }
}

@keyframes scroll-right {
    0% {
        transform: translateX(-100%);
    }
    100% {
        transform: translateX(0);
    }
}

.animate-scroll-left {
    animation: scroll-left 30s linear infinite;
}

.animate-scroll-right {
    animation: scroll-right 30s linear infinite;
}



/* Hover lift effect */
.hover-lift {
    transition: transform 0.3s;
}

.hover-lift:hover {
    transform: translateY(-8px);
}

/* Custom scrollbar */
.overflow-y-auto::-webkit-scrollbar {
    width: 6px;
}

.overflow-y-auto::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 3px;
}

.overflow-y-auto::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.3);
    border-radius: 3px;
}

.overflow-y-auto::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 255, 255, 0.5);
}

/* Plan cards responsive improvements */
@media (max-width: 1280px) {
    .grid-cols-4 {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .grid-cols-4 {
        grid-template-columns: 1fr;
    }
}

/* Custom max-width for larger screens */
.max-w-8xl {
    max-width: 90rem; /* 1440px */
}

.max-w-7xl {
    max-width: 80rem; /* 1280px */
}
</style>
