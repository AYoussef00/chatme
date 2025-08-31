<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import {
    Upload, MessageCircle, FileText, Sparkles, Zap, Shield, Users,
    ArrowRight, Bot, Send, X, CheckCircle, Brain, Globe, Infinity
} from 'lucide-vue-next';

// Types
interface ChatMessage {
    id: number;
    type: 'user' | 'bot';
    message: string;
    timestamp: Date;
}

interface UploadedFile {
    name: string;
    type: string;
    size: number;
}

// Reactive data
const isUploading = ref(false);
const uploadedFile = ref<UploadedFile | null>(null);
const chatMessages = ref<ChatMessage[]>([]);
const currentMessage = ref('');
const isChatting = ref(false);
const showChat = ref(false);

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
    chatMessages.value = [];
    showChat.value = false;
};

// Chat functionality
const startChat = () => {
    if (uploadedFile.value) {
        showChat.value = true;
        chatMessages.value = [{
            id: 1,
            type: 'bot',
            message: `Hello! I've analyzed your PDF "${uploadedFile.value.name}". I'm ready to answer any questions you have about its content. What would you like to know?`,
            timestamp: new Date()
        }];
    }
};

const sendMessage = () => {
    if (currentMessage.value.trim()) {
        chatMessages.value.push({
            id: chatMessages.value.length + 1,
            type: 'user',
            message: currentMessage.value,
            timestamp: new Date()
        });

        const userQuestion = currentMessage.value;
        currentMessage.value = '';
        isChatting.value = true;

        setTimeout(() => {
            chatMessages.value.push({
                id: chatMessages.value.length + 1,
                type: 'bot',
                message: `Based on your PDF content, here's what I found regarding "${userQuestion}": [AI response would be generated here based on the actual PDF content and AI integration]`,
                timestamp: new Date()
            });
            isChatting.value = false;
        }, 1500);
    }
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
            <div class="max-w-7xl mx-auto px-6">
                <div class="flex h-20 items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 p-0.5">
                                <div class="flex h-full w-full items-center justify-center rounded-2xl bg-black">
                                    <Bot class="h-6 w-6 text-white" />
                                </div>
                            </div>
                            <div class="absolute -top-1 -right-1 h-4 w-4 rounded-full bg-green-400 animate-pulse"></div>
                        </div>
                        <div>
                            <span class="text-2xl font-bold bg-gradient-to-r from-white to-gray-300 bg-clip-text text-transparent">ChatMe</span>
                            <div class="text-xs text-gray-500 font-mono">AI-Powered</div>
                        </div>
                    </div>

                    <div class="flex items-center space-x-6">
                        <Link
                            v-if="$page.props.auth.user"
                            href="/dashboard"
                            class="inline-flex items-center rounded-xl bg-white/10 px-6 py-3 text-sm font-medium text-white hover:bg-white/20 transition-all duration-300 border border-white/20 hover:border-white/40"
                        >
                            Dashboard
                        </Link>
                        <template v-else>
                            <Link
                                href="/admin/login"
                                class="text-sm font-medium text-gray-400 hover:text-white transition-colors duration-300"
                            >
                                Sign in
                            </Link>
                            <Link
                                href="/admin/register"
                                class="inline-flex items-center rounded-xl bg-gradient-to-r from-blue-500 to-purple-600 px-6 py-3 text-sm font-medium text-white hover:from-blue-600 hover:to-purple-700 transition-all duration-300 shadow-lg hover:shadow-blue-500/25"
                            >
                                Get Started
                            </Link>
                        </template>
                    </div>
                </div>
            </div>
        </header>

        <!-- Hero Section -->
        <div class="relative z-10 pt-32 pb-20">
            <div class="max-w-7xl mx-auto px-6">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <!-- Left Column - Text Content -->
                    <div class="space-y-8">
                        <div class="inline-flex items-center rounded-3xl bg-white/5 backdrop-blur-sm border border-white/10 px-6 py-3 text-sm font-medium text-white shadow-2xl">
                            <div class="flex items-center space-x-3">
                                <div class="relative">
                                    <div class="h-3 w-3 rounded-full bg-green-400 animate-pulse"></div>
                                    <div class="absolute inset-0 h-3 w-3 rounded-full bg-green-400 animate-ping"></div>
                                </div>
                                <span class="font-semibold">AI Document Intelligence</span>
                            </div>
                            <div class="ml-3 p-1.5 rounded-full bg-gradient-to-r from-purple-500/20 to-pink-500/20 border border-purple-400/30">
                                <Sparkles class="h-4 w-4 text-purple-300 animate-bounce" />
                            </div>
                        </div>

                        <div class="space-y-6">
                            <h1 class="text-6xl md:text-7xl font-black text-white leading-tight">
                                <span class="bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 bg-clip-text text-transparent animate-pulse">AI Document</span>
                                <br>
                                <span class="bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-500 bg-clip-text text-transparent">Intelligence</span>
                            </h1>

                            <p class="text-xl text-gray-300 leading-relaxed max-w-2xl font-light">
                                Transform any PDF into an intelligent conversation partner. Ask questions, get insights, and unlock the hidden knowledge within your documents using cutting-edge AI technology.
                            </p>
                        </div>

                        <!-- Animated Dots -->
                        <div class="flex space-x-2">
                            <div class="w-3 h-3 bg-blue-400 rounded-full animate-bounce"></div>
                            <div class="w-3 h-3 bg-purple-400 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                            <div class="w-3 h-3 bg-pink-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                            <div class="w-3 h-3 bg-emerald-400 rounded-full animate-bounce" style="animation-delay: 0.3s"></div>
                        </div>

                        <!-- Feature Pills -->
                        <div class="flex flex-wrap gap-4">
                            <div class="flex items-center space-x-2 px-4 py-2 rounded-full bg-white/5 border border-white/10 backdrop-blur-sm">
                                <Shield class="w-4 h-4 text-green-400" />
                                <span class="text-sm text-white">Secure & Private</span>
                            </div>
                            <div class="flex items-center space-x-2 px-4 py-2 rounded-full bg-white/5 border border-white/10 backdrop-blur-sm">
                                <Zap class="w-4 h-4 text-blue-400" />
                                <span class="text-sm text-white">Lightning Fast</span>
                            </div>
                            <div class="flex items-center space-x-2 px-4 py-2 rounded-full bg-white/5 border border-white/10 backdrop-blur-sm">
                                <Brain class="w-4 h-4 text-purple-400" />
                                <span class="text-sm text-white">AI Powered</span>
                            </div>
                        </div>

                        <!-- CTA Buttons -->
                        <div class="flex flex-col sm:flex-row gap-6 pt-6">
                            <Link href="/admin/register">
                                <Button size="lg" class="group relative overflow-hidden bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 hover:from-blue-600 hover:via-purple-600 hover:to-pink-600 px-10 py-5 text-lg rounded-3xl shadow-2xl hover:shadow-blue-500/30 transform hover:scale-105 transition-all duration-500 btn-hover-effect">
                                    <span class="relative z-10 flex items-center">
                                        Get Started Free
                                        <ArrowRight class="ml-3 h-5 w-5 group-hover:translate-x-1 transition-transform duration-300" />
                                    </span>
                                    <div class="absolute inset-0 bg-gradient-to-r from-blue-400 via-purple-400 to-pink-400 opacity-0 group-hover:opacity-20 transition-opacity duration-500"></div>
                                </Button>
                            </Link>
                            <Link href="/admin/login">
                                <Button size="lg" variant="outline" class="group border-white/30 text-white hover:bg-white/10 hover:border-white/50 px-10 py-5 text-lg rounded-3xl backdrop-blur-xl transition-all duration-300 hover:shadow-2xl hover:shadow-white/10">
                                    <span class="group-hover:scale-105 transition-transform duration-300">Sign In</span>
                                </Button>
                            </Link>
                        </div>

                        <!-- Stats -->
                        <div class="flex items-center space-x-8 pt-8">
                            <div class="text-center">
                                <div class="text-2xl font-bold text-white">10K+</div>
                                <div class="text-sm text-gray-400">Active Users</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-white">1M+</div>
                                <div class="text-sm text-gray-400">Documents Processed</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold text-white">99.9%</div>
                                <div class="text-sm text-gray-400">Uptime</div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - File Upload Area -->
                    <div class="space-y-6">
                        <!-- File Upload Zone -->
                        <div class="group relative rounded-3xl border-2 border-dashed border-white/20 bg-white/5 p-12 text-center transition-all duration-500 hover:border-blue-500/50 hover:bg-white/10 backdrop-blur-sm hover-lift">
                            <div v-if="!uploadedFile" class="space-y-6">
                                <!-- Upload Icon -->
                                <div class="mx-auto w-24 h-24 rounded-full bg-gradient-to-br from-blue-500/20 via-purple-500/20 to-pink-500/20 border border-white/20 flex items-center justify-center group-hover:scale-110 transition-all duration-500 animate-scale">
                                    <Upload class="h-12 w-12 text-blue-400 group-hover:text-purple-400 transition-colors duration-500" />
                                </div>

                                <!-- Text Content -->
                                <div class="space-y-3">
                                    <h3 class="text-2xl font-bold text-white">
                                        Upload Your Document
                                    </h3>
                                    <p class="text-gray-300 text-sm max-w-xs mx-auto">
                                        Drag and drop your PDF file here or click the button below to browse
                                    </p>
                                </div>

                                <!-- Upload Button -->
                                <div class="pt-4">
                                    <Label for="pdf-upload" class="cursor-pointer">
                                        <div class="inline-flex items-center rounded-2xl bg-gradient-to-r from-blue-500 to-purple-600 px-8 py-4 text-white font-semibold shadow-lg hover:shadow-blue-500/25 transition-all duration-500 transform hover:scale-105 btn-hover-effect">
                                            <FileText class="mr-3 h-5 w-5" />
                                            <span>Select PDF File</span>
                                        </div>
                                    </Label>
                                </div>
                            </div>

                            <!-- Upload Progress State -->
                            <div v-else-if="isUploading" class="space-y-6">
                                <div class="mx-auto w-24 h-24 rounded-full bg-gradient-to-br from-blue-500/20 via-purple-500/20 to-pink-500/20 border border-white/20 flex items-center justify-center">
                                    <Upload class="h-12 w-12 text-blue-400 animate-bounce" />
                                </div>

                                <div class="space-y-4">
                                    <h3 class="text-2xl font-bold text-white">
                                        Uploading Document...
                                    </h3>
                                    <p class="text-gray-300 text-sm">
                                        Please wait while we process your PDF file
                                    </p>

                                    <!-- Progress Bar -->
                                    <div class="w-full bg-white/10 rounded-full h-2 overflow-hidden">
                                        <div class="bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 h-2 rounded-full animate-pulse shimmer" style="width: 100%"></div>
                                    </div>

                                    <!-- Loading Dots -->
                                    <div class="flex justify-center space-x-2">
                                        <div class="w-2 h-2 bg-blue-400 rounded-full animate-bounce"></div>
                                        <div class="w-2 h-2 bg-purple-400 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                                        <div class="w-2 h-2 bg-pink-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Success State -->
                            <div v-else class="space-y-6">
                                <div class="mx-auto w-24 h-24 rounded-full bg-green-500/20 border border-green-400/30 flex items-center justify-center">
                                    <CheckCircle class="h-12 w-12 text-green-400" />
                                </div>

                                <div class="space-y-3">
                                    <h3 class="text-2xl font-bold text-white">
                                        File Uploaded Successfully!
                                    </h3>
                                    <p class="text-gray-300 text-sm">
                                        {{ uploadedFile.name }}
                                    </p>
                                </div>

                                <!-- Action Buttons -->
                                <div class="space-y-3">
                                    <Button @click="startChat" class="w-full bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 px-8 py-4 text-white font-semibold rounded-2xl shadow-lg hover:shadow-blue-500/25 transition-all duration-500 transform hover:scale-105 btn-hover-effect">
                                        <MessageCircle class="mr-3 h-5 w-5" />
                                        Start AI Chat
                                    </Button>
                                    <Button @click="removeFile" variant="outline" class="w-full border-white/30 text-white hover:bg-white/10 hover:border-white/50 px-8 py-4 text-sm rounded-2xl backdrop-blur-xl transition-all duration-300">
                                        <X class="mr-3 h-4 w-4" />
                                        Remove File
                                    </Button>
                                </div>
                            </div>
                        </div>

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

        <!-- Chat Interface -->
        <div v-if="showChat" class="fixed inset-0 z-50 flex items-end justify-center p-4 sm:items-center">
            <div class="fixed inset-0 bg-black/80 backdrop-blur-sm" @click="showChat = false"></div>
            <Card class="relative w-full max-w-4xl bg-black/90 border border-white/20 backdrop-blur-xl">
                <CardHeader class="border-b border-white/10 bg-white/5">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-r from-blue-500 to-purple-600">
                                <Bot class="h-5 w-5 text-white" />
                            </div>
                            <div>
                                <CardTitle class="text-xl text-white">AI Chat Assistant</CardTitle>
                                <CardDescription class="text-gray-400">{{ uploadedFile?.name }}</CardDescription>
                            </div>
                        </div>
                        <Button variant="ghost" size="sm" @click="showChat = false" class="text-gray-400 hover:text-white hover:bg-white/10">
                            <X class="h-5 w-5" />
                        </Button>
                    </div>
                </CardHeader>

                <CardContent class="p-0">
                    <div class="h-[500px] overflow-y-auto p-6 space-y-6 bg-gradient-to-b from-black/50 to-black/90">
                        <div v-for="message in chatMessages" :key="message.id" class="flex space-x-4">
                            <div v-if="message.type === 'bot'" class="flex-shrink-0">
                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-r from-blue-500 to-purple-600">
                                    <Bot class="h-5 w-5 text-white" />
                                </div>
                            </div>
                            <div v-else class="flex-shrink-0">
                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-white/10 border border-white/20">
                                    <Users class="h-5 w-5 text-white" />
                                </div>
                            </div>
                            <div class="flex-1">
                                <div :class="[
                                    'rounded-2xl px-6 py-4 text-sm leading-relaxed',
                                    message.type === 'bot'
                                        ? 'bg-white/5 text-white border border-white/10'
                                        : 'bg-gradient-to-r from-blue-500/20 to-purple-500/20 text-white border border-blue-400/20'
                                ]">
                                    {{ message.message }}
                                </div>
                                <div class="mt-2 text-xs text-gray-500 font-mono">
                                    {{ message.timestamp.toLocaleTimeString() }}
                                </div>
                            </div>
                        </div>

                        <div v-if="isChatting" class="flex space-x-4">
                            <div class="flex-shrink-0">
                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-r from-blue-500 to-purple-600">
                                    <Bot class="h-5 w-5 text-white" />
                                </div>
                            </div>
                            <div class="flex-1">
                                <div class="rounded-2xl bg-white/5 px-6 py-4 border border-white/10">
                                    <div class="flex space-x-2">
                                        <div class="h-2 w-2 animate-bounce rounded-full bg-blue-400"></div>
                                        <div class="h-2 w-2 animate-bounce rounded-full bg-purple-400" style="animation-delay: 0.1s"></div>
                                        <div class="h-2 w-2 animate-bounce rounded-full bg-blue-400" style="animation-delay: 0.2s"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-white/10 p-6 bg-black/50">
                        <div class="flex space-x-3">
                            <Input
                                v-model="currentMessage"
                                placeholder="Ask a question about your PDF..."
                                class="flex-1 bg-white/5 border-white/20 text-white placeholder-gray-400 rounded-2xl focus:border-blue-500 focus:ring-blue-500"
                                @keyup.enter="sendMessage"
                            />
                            <Button @click="sendMessage" :disabled="!currentMessage.trim() || isChatting" class="bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 rounded-2xl px-6">
                                <Send class="h-4 w-4" />
                            </Button>
                        </div>
                    </div>
                </CardContent>
            </Card>
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
</style>
