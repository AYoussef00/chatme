<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { ref, onMounted, nextTick } from 'vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import {
    Bot, Users, Send, X, ArrowLeft, Sparkles,
    Paperclip, Image, Mic, Smile, MoreHorizontal,
    Plus, Search, MessageCircle, Settings, HelpCircle, LogOut
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

interface ChatMessage {
    id: number;
    type: 'user' | 'bot';
    message: string;
    timestamp: Date;
    status?: 'sending' | 'sent' | 'delivered' | 'read';
}

// Props
interface Props {
    plans?: Plan[];
}

const props = withDefaults(defineProps<Props>(), {
    plans: () => []
});

// Reactive data
const chatMessages = ref<ChatMessage[]>([]);
const currentMessage = ref('');
const isTyping = ref(false);
const messagesEndRef = ref<HTMLElement>();

// Initialize chat with welcome message
onMounted(() => {
    // Add welcome message
    chatMessages.value = [
        {
            id: 1,
            type: 'bot',
            message: 'Hello! I\'m your AI assistant. How can I help you today?',
            timestamp: new Date(),
            status: 'read'
        }
    ];

    scrollToBottom();
});

// Scroll to bottom of chat
const scrollToBottom = async () => {
    await nextTick();
    if (messagesEndRef.value) {
        messagesEndRef.value.scrollIntoView({ behavior: 'smooth' });
    }
};

// Send message
const sendMessage = async () => {
    if (currentMessage.value.trim()) {
        // Add user message
        const userMessage: ChatMessage = {
            id: chatMessages.value.length + 1,
            type: 'user',
            message: currentMessage.value,
            timestamp: new Date(),
            status: 'sending'
        };

        chatMessages.value.push(userMessage);
        const userQuestion = currentMessage.value;
        currentMessage.value = '';

        // Scroll to bottom
        await scrollToBottom();

        // Simulate typing
        isTyping.value = true;

        // Simulate AI response after delay
        setTimeout(async () => {
            isTyping.value = false;

            const botMessage: ChatMessage = {
                id: chatMessages.value.length + 1,
                type: 'bot',
                message: `I see you're asking about "${userQuestion}". That's a great question! Let me help you...`,
                timestamp: new Date(),
                status: 'read'
            };

            chatMessages.value.push(botMessage);

            // Update user message status
            userMessage.status = 'read';

            // Scroll to bottom
            await scrollToBottom();
        }, 2000);
    }
};

// Handle Enter key
const handleKeyPress = (event: KeyboardEvent) => {
    if (event.key === 'Enter' && !event.shiftKey) {
        event.preventDefault();
        sendMessage();
    }
};

// Format time
const formatTime = (date: Date) => {
    return date.toLocaleTimeString('en-US', {
        hour: '2-digit',
        minute: '2-digit',
        hour12: true
    });
};

// Get status icon
const getStatusIcon = (status: string) => {
    switch (status) {
        case 'sending':
            return '⏳';
        case 'sent':
            return '✓';
        case 'delivered':
            return '✓✓';
        case 'read':
            return '✓✓';
        default:
            return '';
    }
};
</script>

<template>
    <Head title="AI Chat - ChatMe">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>

    <div class="min-h-screen bg-gray-900 relative">
        <!-- Chat Header -->
        <div class="fixed top-0 left-0 right-0 z-50 bg-gray-900 border-b border-gray-700">
            <div class="flex items-center justify-between px-4 py-3">
                <div class="flex items-center space-x-3">
                    <Button variant="ghost" size="sm" @click="$router.back()" class="text-gray-400 hover:text-white hover:bg-gray-800">
                        <ArrowLeft class="h-5 w-5" />
                    </Button>
                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-gradient-to-r from-blue-500 to-purple-600">
                        <Bot class="h-4 w-4 text-white" />
                    </div>
                    <div>
                        <h1 class="text-lg font-semibold text-white">AI Chat Assistant</h1>
                        <p class="text-xs text-gray-400">{{ props.plans[0]?.name || 'Free Plan' }} - Online</p>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <Button variant="ghost" size="sm" class="text-gray-400 hover:text-white hover:bg-gray-800">
                        <MoreHorizontal class="h-5 w-5" />
                    </Button>
                </div>
            </div>
        </div>

        <!-- Chat Messages Area -->
        <div class="pb-24 px-4 h-screen overflow-y-auto bg-gray-900">
            <div class="w-full px-8 pl-80 pr-80">
                <!-- Welcome Message -->
                <div class="text-center py-4">
                    <div class="inline-flex items-center space-x-2 px-4 py-3 rounded-full bg-gray-800 border border-gray-600">
                        <Sparkles class="h-5 w-5 text-blue-400" />
                        <span class="text-base text-gray-300">AI Assistant</span>
                    </div>
                </div>

                                <!-- Messages -->
                <div v-for="message in chatMessages" :key="message.id" class="mb-8">
                    <!-- Bot Message -->
                    <div v-if="message.type === 'bot'" class="flex space-x-6">
                        <div class="flex-shrink-0">
                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-r from-blue-500 to-purple-600">
                                <Bot class="h-5 w-5 text-white" />
                            </div>
                        </div>
                        <div class="flex-1 max-w-4xl">
                            <div class="bg-gray-800 rounded-2xl px-6 py-4 text-gray-100">
                                <div class="text-base leading-relaxed">{{ message.message }}</div>
                                <div class="mt-3 text-sm text-gray-500">
                                    {{ formatTime(message.timestamp) }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- User Message -->
                    <div v-else class="flex justify-end space-x-6">
                        <div class="flex-1 max-w-4xl"></div>
                        <div class="flex-shrink-0">
                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-r from-purple-500 to-pink-500">
                                <Users class="h-5 w-5 text-white" />
                            </div>
                        </div>
                        <div class="max-w-4xl">
                            <div class="bg-blue-600 rounded-2xl px-6 py-4 text-white">
                                <div class="text-base leading-relaxed">{{ message.message }}</div>
                                <div class="mt-3 text-sm text-blue-200 flex items-center justify-between">
                                    <span>{{ formatTime(message.timestamp) }}</span>
                                    <span class="ml-3">{{ getStatusIcon(message.status || '') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Typing Indicator -->
                <div v-if="isTyping" class="flex space-x-6 mb-8">
                    <div class="flex-shrink-0">
                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-r from-blue-500 to-purple-600">
                            <Bot class="h-5 w-5 text-white" />
                        </div>
                    </div>
                    <div class="bg-gray-800 rounded-2xl px-6 py-4">
                        <div class="flex space-x-2">
                            <div class="w-3 h-3 bg-blue-400 rounded-full animate-bounce"></div>
                            <div class="w-3 h-3 bg-purple-400 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                            <div class="w-3 h-3 bg-pink-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                        </div>
                    </div>
                </div>

                        <!-- Scroll anchor -->
        <div ref="messagesEndRef"></div>
    </div>
</div>

        <!-- Left Sidebar -->
        <div class="fixed top-16 left-0 w-80 h-screen bg-gray-800 border-r border-gray-700 overflow-y-auto">
            <div class="p-6 space-y-6">
                <!-- Subscription Plan -->
                <div class="bg-gradient-to-br from-blue-600 to-purple-600 rounded-xl p-4">
                    <div class="flex items-center space-x-3 mb-3">
                        <div class="w-3 h-3 bg-white rounded-full"></div>
                        <h3 class="text-white font-semibold text-sm">{{ props.plans[0]?.name || 'Free Plan' }}</h3>
                    </div>
                    <div class="space-y-2 mb-4">
                        <div class="text-white text-xs">
                            <span class="font-medium">Current Plan:</span> Free Tier
                        </div>
                        <div class="text-white text-xs">
                            <span class="font-medium">Next Billing:</span> Never
                        </div>
                    </div>
                    <Button class="w-full bg-white text-blue-600 hover:bg-gray-100 text-xs py-2 rounded-lg">
                        Upgrade Plan
                    </Button>
                </div>

                <!-- Model Information -->
                <div class="bg-gray-700 rounded-xl p-4">
                    <div class="flex items-center space-x-3 mb-3">
                        <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
                        <h3 class="text-white font-semibold text-sm">AI Model</h3>
                    </div>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-gray-300 text-xs mb-2">Select Model:</label>
                            <select class="w-full bg-gray-600 border border-gray-500 text-white text-xs rounded-lg px-3 py-2 focus:border-blue-500 focus:ring-blue-500 focus:outline-none">
                                <option value="gpt-4-turbo" selected>GPT-4 Turbo</option>
                                <option value="gpt-4">GPT-4</option>
                                <option value="gpt-3.5-turbo">GPT-3.5 Turbo</option>
                                <option value="claude-3">Claude 3</option>
                                <option value="gemini-pro">Gemini Pro</option>
                                <option value="llama-2">Llama 2</option>
                            </select>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-300 text-xs">Version:</span>
                            <span class="text-white text-xs font-medium">Latest</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-300 text-xs">Status:</span>
                            <span class="text-green-400 text-xs font-medium">Active</span>
                        </div>
                    </div>
                </div>

                <!-- Usage Statistics -->
                <div class="bg-gray-700 rounded-xl p-4">
                    <div class="flex items-center space-x-3 mb-3">
                        <div class="w-3 h-3 bg-blue-400 rounded-full"></div>
                        <h3 class="text-white font-semibold text-sm">Usage</h3>
                    </div>
                    <div class="space-y-3">
                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-gray-300 text-xs">Messages Today</span>
                                <span class="text-white text-xs font-medium">12/50</span>
                            </div>
                            <div class="w-full bg-gray-600 rounded-full h-2">
                                <div class="bg-blue-500 h-2 rounded-full" style="width: 24%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-gray-300 text-xs">Tokens Used</span>
                                <span class="text-white text-xs font-medium">2,847</span>
                            </div>
                            <div class="w-full bg-gray-600 rounded-full h-2">
                                <div class="bg-purple-500 h-2 rounded-full" style="width: 35%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-gray-300 text-xs">Files Uploaded</span>
                                <span class="text-white text-xs font-medium">3/10</span>
                            </div>
                            <div class="w-full bg-gray-600 rounded-full h-2">
                                <div class="bg-pink-500 h-2 rounded-full" style="width: 30%"></div>
                            </div>
                        </div>
                    </div>
                </div>




            </div>
        </div>

        <!-- Right Sidebar - Chat History -->
        <div class="fixed top-16 right-0 w-80 h-screen bg-gray-800 border-l border-gray-700 overflow-y-auto">
            <div class="p-6 space-y-6">
                                <!-- New Chat Button -->
                <div class="bg-gradient-to-br from-blue-600 to-purple-600 rounded-xl p-4">
                    <Button class="w-full bg-white text-blue-600 hover:bg-gray-50 text-sm py-3 rounded-lg font-medium transition-colors duration-200">
                        <Plus class="h-4 w-4 mr-2" />
                        New Chat
                    </Button>
                </div>



                <!-- Chat History -->
                <div class="bg-gray-700 rounded-xl p-4">
                    <h3 class="text-white font-semibold text-sm mb-4">Recent Chats</h3>
                    <div class="space-y-3">
                        <!-- Chat Item 1 -->
                        <div class="flex items-center space-x-3 p-3 bg-gray-600 rounded-lg hover:bg-gray-500 cursor-pointer transition-colors">
                            <div class="w-8 h-8 bg-gray-500 rounded-full flex items-center justify-center">
                                <span class="text-white text-sm font-bold">#1</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-white text-sm font-medium truncate">AI Assistant Chat</p>
                                <p class="text-gray-400 text-xs truncate">Hello! I'm your AI assistant...</p>
                            </div>
                            <div class="text-gray-500 text-xs">02:21 PM</div>
                        </div>

                        <!-- Chat Item 2 -->
                        <div class="flex items-center space-x-3 p-3 bg-gray-600 rounded-lg hover:bg-gray-500 cursor-pointer transition-colors">
                            <div class="w-8 h-8 bg-gray-500 rounded-full flex items-center justify-center">
                                <span class="text-white text-sm font-bold">#2</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-white text-sm font-medium truncate">Project Discussion</p>
                                <p class="text-gray-400 text-xs truncate">Let's discuss the project...</p>
                            </div>
                            <div class="text-gray-500 text-xs">Yesterday</div>
                        </div>

                        <!-- Chat Item 3 -->
                        <div class="flex items-center space-x-3 p-3 bg-gray-600 rounded-lg hover:bg-gray-500 cursor-pointer transition-colors">
                            <div class="w-8 h-8 bg-gray-500 rounded-full flex items-center justify-center">
                                <span class="text-white text-sm font-bold">#3</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-white text-sm font-medium truncate">Code Review</p>
                                <p class="text-gray-400 text-xs truncate">Can you review this code...</p>
                            </div>
                            <div class="text-gray-500 text-xs">2 days ago</div>
                        </div>

                        <!-- Chat Item 4 -->
                        <div class="flex items-center space-x-3 p-3 bg-gray-600 rounded-lg hover:bg-gray-500 cursor-pointer transition-colors">
                            <div class="w-8 h-8 bg-gray-500 rounded-full flex items-center justify-center">
                                <span class="text-white text-sm font-bold">#4</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-white text-sm font-medium truncate">Design Ideas</p>
                                <p class="text-gray-400 text-xs truncate">I need some design ideas...</p>
                            </div>
                            <div class="text-gray-500 text-xs">3 days ago</div>
                        </div>

                        <!-- Chat Item 5 -->
                        <div class="flex items-center space-x-3 p-3 bg-gray-600 rounded-lg hover:bg-gray-500 cursor-pointer transition-colors">
                            <div class="w-8 h-8 bg-gray-500 rounded-full flex items-center justify-center">
                                <span class="text-white text-sm font-bold">#5</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-white text-sm font-medium truncate">Bug Fix Help</p>
                                <p class="text-gray-400 text-xs truncate">I found a bug in the...</p>
                            </div>
                            <div class="text-gray-500 text-xs">1 week ago</div>
                        </div>
                    </div>
                </div>


            </div>
        </div>

        <!-- Chat Input Area -->
        <div class="fixed bottom-0 left-0 right-0 bg-gray-900 border-t border-gray-700">
            <div class="max-w-4xl mx-auto px-4 py-4">
                <div class="flex items-end space-x-3">
                    <!-- Attachment Button -->
                    <Button variant="ghost" size="sm" class="text-gray-400 hover:text-white hover:bg-gray-800 p-2">
                        <Paperclip class="h-5 w-5" />
                    </Button>

                    <!-- Image Button -->
                    <Button variant="ghost" size="sm" class="text-gray-400 hover:text-white hover:bg-gray-800 p-2">
                        <Image class="h-5 w-5" />
                    </Button>

                    <!-- Main Input -->
                    <div class="flex-1 relative">
                        <Input
                            v-model="currentMessage"
                            placeholder="Type your message here..."
                            class="w-full bg-gray-800 border-gray-600 text-white placeholder-gray-400 rounded-2xl focus:border-blue-500 focus:ring-blue-500 pr-12 py-3"
                            @keypress="handleKeyPress"
                        />
                        <Button
                            variant="ghost"
                            size="sm"
                            class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-white hover:bg-gray-800 p-1"
                        >
                            <Smile class="h-4 w-4" />
                        </Button>
                    </div>

                    <!-- Send Button -->
                    <Button
                        @click="sendMessage"
                        :disabled="!currentMessage.trim() || isTyping"
                        class="bg-blue-600 hover:bg-blue-700 rounded-2xl p-3 disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        <Send class="h-5 w-5" />
                    </Button>

                    <!-- Voice Button -->
                    <Button variant="ghost" size="sm" class="text-gray-400 hover:text-white hover:bg-gray-800 p-2">
                        <Mic class="h-5 w-5" />
                    </Button>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
/* Custom scrollbar */
.overflow-y-auto::-webkit-scrollbar {
    width: 8px;
}

.overflow-y-auto::-webkit-scrollbar-track {
    background: #374151;
    border-radius: 4px;
}

.overflow-y-auto::-webkit-scrollbar-thumb {
    background: #6B7280;
    border-radius: 4px;
}

.overflow-y-auto::-webkit-scrollbar-thumb:hover {
    background: #9CA3AF;
}

/* Message animations */
.message-enter-active {
    transition: all 0.3s ease;
}

.message-enter-from {
    opacity: 0;
    transform: translateY(20px);
}

.message-enter-to {
    opacity: 1;
    transform: translateY(0);
}

/* Typing animation */
@keyframes typing {
    0%, 20% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-10px);
    }
    80%, 100% {
        transform: translateY(0);
    }
}

.animate-typing {
    animation: typing 1.4s infinite;
}
</style>
