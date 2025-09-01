<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import {
    Search, MessageCircle, FileText, Users, Settings, Shield,
    Zap, Globe, HelpCircle, ChevronRight, BookOpen, Video,
    Phone, Mail, Clock, Star, ArrowLeft
} from 'lucide-vue-next';

interface Plan {
    id: number;
    name: string;
    description: string | null;
    price: number;
    duration: string;
    features: string[] | null;
    is_active: boolean;
}

interface Props {
    plans?: Plan[];
}

const props = withDefaults(defineProps<Props>(), {
    plans: () => []
});

// Reactive data
const searchQuery = ref('');
const activeCategory = ref('getting-started');
const activeFAQ = ref<number | null>(null);

// FAQ data
const faqs = {
    'getting-started': [
        {
            id: 1,
            question: "How do I upload my first document?",
            answer: "Simply drag and drop your PDF file onto the upload area, or click to browse and select a file. Our system supports all major document formats including PDF, DOC, DOCX, and TXT files."
        },
        {
            id: 2,
            question: "What types of documents can I chat with?",
            answer: "You can chat with research papers, books, legal documents, business reports, academic papers, technical documentation, and many more. Our AI understands context across various domains."
        },
        {
            id: 3,
            question: "How accurate are the AI responses?",
            answer: "Our AI provides highly accurate responses based on the content of your uploaded documents. It uses advanced language models to understand context and provide relevant, helpful information."
        }
    ],
    'features': [
        {
            id: 4,
            question: "Can I create custom AI personalities?",
            answer: "Yes! You can create custom AI personalities for different types of conversations. This allows you to have specialized interactions based on your specific needs and preferences."
        },
        {
            id: 5,
            question: "How many documents can I upload?",
            answer: "The number depends on your plan. Free users can upload 5 documents per month, Pro users get 100 documents, and Enterprise users have unlimited uploads."
        },
        {
            id: 6,
            question: "Is my data secure?",
            answer: "Absolutely. We use enterprise-grade encryption and security measures to protect your documents. Your data is never shared with third parties and is processed securely."
        }
    ],
    'billing': [
        {
            id: 7,
            question: "What payment methods do you accept?",
                            answer: `We accept all major credit cards (Visa, MasterCard, American Express), PayPal, and bank transfers for ${props.plans[2]?.name || 'Enterprise'} plans. All payments are processed securely through Stripe.`
        },
        {
            id: 8,
            question: "Can I cancel my subscription anytime?",
            answer: "Yes, you can cancel your subscription at any time. There are no long-term contracts or cancellation fees. You'll continue to have access until the end of your billing period."
        },
        {
            id: 9,
            question: "Do you offer refunds?",
            answer: "We offer a 30-day money-back guarantee. If you're not satisfied with our service, contact our support team within 30 days of your purchase for a full refund."
        }
    ]
};

// Search functionality
const filteredFAQs = ref(Object.values(faqs).flat());

const handleSearch = () => {
    if (!searchQuery.value.trim()) {
        filteredFAQs.value = Object.values(faqs).flat();
        return;
    }

    const query = searchQuery.value.toLowerCase();
    filteredFAQs.value = Object.values(faqs)
        .flat()
        .filter(faq =>
            faq.question.toLowerCase().includes(query) ||
            faq.answer.toLowerCase().includes(query)
        );
};

// Toggle FAQ
const toggleFAQ = (id: number) => {
    activeFAQ.value = activeFAQ.value === id ? null : id;
};

// Set active category
const setCategory = (category: string) => {
    activeCategory.value = category;
    filteredFAQs.value = faqs[category as keyof typeof faqs] || [];
};
</script>

<template>
    <Head title="Help Center - ChatMe">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>

    <div class="min-h-screen bg-black relative overflow-hidden">
        <!-- Animated Background -->
        <div class="fixed inset-0 bg-gradient-to-br from-black via-gray-900 to-black">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_50%,rgba(120,119,198,0.1),transparent_50%)]"></div>
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_80%_20%,rgba(120,119,198,0.05),transparent_50%)]"></div>
        </div>

        <!-- Header -->
        <header class="relative z-10 border-b border-white/10 bg-black/50 backdrop-blur-sm">
            <div class="max-w-7xl mx-auto px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <Button variant="ghost" size="sm" @click="$router.back()" class="text-gray-400 hover:text-white hover:bg-white/10">
                            <ArrowLeft class="h-5 w-5" />
                        </Button>
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                                <MessageCircle class="h-5 w-5 text-white" />
                            </div>
                            <h1 class="text-xl font-bold text-white">Help Center</h1>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <Button variant="ghost" size="sm" class="text-gray-400 hover:text-white hover:bg-white/10">
                            <Phone class="h-4 w-4" />
                        </Button>
                        <Button variant="ghost" size="sm" class="text-gray-400 hover:text-white hover:bg-white/10">
                            <Mail class="h-4 w-4" />
                        </Button>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="relative z-10 pt-8">
            <div class="max-w-7xl mx-auto px-6">
                <!-- Hero Section -->
                <div class="text-center mb-12">
                    <h2 class="text-4xl font-bold text-white mb-4 gradient-text">How can we help you?</h2>
                    <p class="text-xl text-gray-400 mb-8">Find answers to common questions and learn how to get the most out of ChatMe</p>

                    <!-- Search Bar -->
                    <div class="max-w-2xl mx-auto relative">
                        <Search class="absolute left-4 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400" />
                        <Input
                            v-model="searchQuery"
                            @input="handleSearch"
                            placeholder="Search for help articles, FAQs, and guides..."
                            class="w-full pl-12 pr-4 py-4 bg-white/10 border-white/20 text-white placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500 rounded-2xl"
                        />
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="grid md:grid-cols-4 gap-6 mb-12">
                    <div class="p-6 rounded-2xl bg-white/5 backdrop-blur-sm border border-white/10 hover:bg-white/10 transition-all duration-300 cursor-pointer">
                        <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl flex items-center justify-center mb-4">
                            <BookOpen class="h-6 w-6 text-white" />
                        </div>
                        <h3 class="text-white font-semibold mb-2">Documentation</h3>
                        <p class="text-gray-400 text-sm">Comprehensive guides and tutorials</p>
                    </div>

                    <div class="p-6 rounded-2xl bg-white/5 backdrop-blur-sm border border-white/10 hover:bg-white/10 transition-all duration-300 cursor-pointer">
                        <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-pink-600 rounded-xl flex items-center justify-center mb-4">
                            <Video class="h-6 w-6 text-white" />
                        </div>
                        <h3 class="text-white font-semibold mb-2">Video Tutorials</h3>
                        <p class="text-gray-400 text-sm">Step-by-step video guides</p>
                    </div>

                    <div class="p-6 rounded-2xl bg-white/5 backdrop-blur-sm border border-white/10 hover:bg-white/10 transition-all duration-300 cursor-pointer">
                        <div class="w-12 h-12 bg-gradient-to-r from-pink-500 to-rose-600 rounded-xl flex items-center justify-center mb-4">
                            <Users class="h-6 w-6 text-white" />
                        </div>
                        <h3 class="text-white font-semibold mb-2">Community</h3>
                        <p class="text-gray-400 text-sm">Connect with other users</p>
                    </div>

                    <div class="p-6 rounded-2xl bg-white/5 backdrop-blur-sm border border-white/10 hover:bg-white/10 transition-all duration-300 cursor-pointer">
                        <div class="w-12 h-12 bg-gradient-to-r from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center mb-4">
                            <HelpCircle class="h-6 w-6 text-white" />
                        </div>
                        <h3 class="text-white font-semibold mb-2">Contact Support</h3>
                        <p class="text-gray-400 text-sm">Get help from our team</p>
                    </div>
                </div>

                <!-- Categories and FAQ -->
                <div class="grid lg:grid-cols-4 gap-8">
                    <!-- Categories Sidebar -->
                    <div class="lg:col-span-1">
                        <div class="sticky top-8">
                            <h3 class="text-white font-semibold text-lg mb-4">Categories</h3>
                            <div class="space-y-2">
                                <button
                                    @click="setCategory('getting-started')"
                                    :class="[
                                        'w-full text-left px-4 py-3 rounded-xl transition-all duration-300',
                                        activeCategory === 'getting-started'
                                            ? 'bg-blue-600/20 border border-blue-500/30 text-blue-400'
                                            : 'text-gray-400 hover:text-white hover:bg-white/10'
                                    ]"
                                >
                                    <div class="flex items-center justify-between">
                                        <span>Getting Started</span>
                                        <ChevronRight class="h-4 w-4" />
                                    </div>
                                </button>

                                <button
                                    @click="setCategory('features')"
                                    :class="[
                                        'w-full text-left px-4 py-3 rounded-xl transition-all duration-300',
                                        activeCategory === 'features'
                                            ? 'bg-purple-600/20 border border-purple-500/30 text-purple-400'
                                            : 'text-gray-400 hover:text-white hover:bg-white/10'
                                    ]"
                                >
                                    <div class="flex items-center justify-between">
                                        <span>Features & Usage</span>
                                        <ChevronRight class="h-4 w-4" />
                                    </div>
                                </button>

                                <button
                                    @click="setCategory('billing')"
                                    :class="[
                                        'w-full text-left px-4 py-3 rounded-xl transition-all duration-300',
                                        activeCategory === 'billing'
                                            ? 'bg-pink-600/20 border border-pink-500/30 text-pink-400'
                                            : 'text-gray-400 hover:text-white hover:bg-white/10'
                                    ]"
                                >
                                    <div class="flex items-center justify-between">
                                        <span>Billing & Plans</span>
                                        <ChevronRight class="h-4 w-4" />
                                    </div>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Content -->
                    <div class="lg:col-span-3">
                        <div class="space-y-6">
                            <div v-for="faq in filteredFAQs" :key="faq.id" class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl overflow-hidden">
                                <button
                                    @click="toggleFAQ(faq.id)"
                                    class="w-full px-6 py-4 text-left hover:bg-white/10 transition-all duration-300"
                                >
                                    <div class="flex items-center justify-between">
                                        <h4 class="text-white font-semibold text-lg">{{ faq.question }}</h4>
                                        <ChevronRight
                                            :class="[
                                                'h-5 w-5 text-gray-400 transition-transform duration-300',
                                                activeFAQ === faq.id ? 'rotate-90' : ''
                                            ]"
                                        />
                                    </div>
                                </button>

                                <div v-if="activeFAQ === faq.id" class="px-6 pb-4">
                                    <div class="border-t border-white/10 pt-4">
                                        <p class="text-gray-300 leading-relaxed">{{ faq.answer }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Section -->
                <div class="mt-20 text-center">
                    <div class="max-w-3xl mx-auto p-8 rounded-3xl bg-gradient-to-br from-blue-600/10 to-purple-600/10 border border-blue-500/20">
                        <h3 class="text-2xl font-bold text-white mb-4">Still need help?</h3>
                        <p class="text-gray-400 mb-6">Our support team is here to help you get the most out of ChatMe</p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <Button class="bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 px-8 py-3">
                                <Mail class="h-4 w-4 mr-2" />
                                Email Support
                            </Button>
                            <Button variant="outline" class="border-white/20 text-white hover:bg-white/10 px-8 py-3">
                                <Phone class="h-4 w-4 mr-2" />
                                Call Us
                            </Button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<style scoped>
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
</style>
