<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DictationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('dictations')->insert([
            [
                'id' => 1,
                'dictation_topic_id' => 12,
                'language_variant_id' => 1,
                'premium' => 0,
                'title' => 'The Impact of Technology on Society','text' => 'Technology deeply permeates modern society. It influences how we communicate, interact, and understand the world around us. From digital platforms enhancing global connection to artificial intelligence automating tasks, technology truly transforms our lives. Its effects also permeate economics, making trade seamless and driving market trends. However, while technology brings myriad advantages, it also poses challenges. Issues such as privacy invasion and dependency require careful regulation. Balancing these aspects remains crucial to leverage the best technology offers while mitigating its drawbacks.','path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/1.+(American)+The+Impact+of+Technology+on+Society.mp3',
                'sort_order' => 1,
                'enabled' => 1
            ],
            [
                'id' => 2,
                'dictation_topic_id' => 12,
                'language_variant_id' => 1,
                'premium' => 1,
                'title' => 'How Technology is Revolutionizing Healthcare','text' => 'The impact of technology on healthcare is profound. With advanced devices, doctors diagnose diseases accurately and swiftly. Technologies like telemedicine bring medical services directly to patients, breaking geographic boundaries. Robotic surgery improves precision, minimizes invasiveness, and quickens recovery times. Gene editing techniques promise cures for inherited diseases. On the mental health front, apps offer therapy and mindfulness exercises. But all these advancements need to uphold ethical standards. It\'s essential to ensure equal access and prioritize patient privacy.','path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/2.+(American)+How+Technology+is+Revolutionizing+Healthcare.mp3',
                'sort_order' => 2,
                'enabled' => 1
            ],
            [
                'id' => 3,
                'dictation_topic_id' => 12,
                'language_variant_id' => 1,
                'premium' => 1,
                'title' => 'The Future of Virtual Reality Technology','text' => 'Virtual reality technology, often shortened as VR, opens doors to simulated environments unlike any real-world setting. Its applications extend beyond entertainment and gaming. VR can enhance immersive learning, allowing students to virtually visit space or ancient civilizations. In the business sector, VR offers realistic product demos and virtual tours. Mental health professionals use VR for exposure therapy, providing safe environments for patients to confront fears. Future advancements may allow even more immersive experiences, with tangible holographic projections and mind-controlled virtual environments.','path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/3.+(American)+The+Future+of+Virtual+Reality+Technology.mp3',
                'sort_order' => 3,
                'enabled' => 1
            ],
            [
                'id' => 4,
                'dictation_topic_id' => 12,
                'language_variant_id' => 1,
                'premium' => 1,
                'title' => 'The Evolution of Smart Home Technology','text' => 'Smart home technology is reshaping our domestic lives. It enables a connected and automated living space, adjusting to our habits and preferences. Smart lights dim or brighten based on time or activity, while smart thermostats regulate home temperature. Smart refrigerators keep track of grocery lists, and automated vacuum cleaners maintain a clean house. Moreover, smart home security systems ensure safety with camera surveillance and alarms. These integrations provide convenience, efficiency, and peace of mind. Yet, they also pose security risks which must be addressed responsibly.','path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/4.+(American)+The+Evolution+of+Smart+Home+Technology.mp3',
                'sort_order' => 4,
                'enabled' => 1
            ],
            [
                'id' => 5,
                'dictation_topic_id' => 12,
                'language_variant_id' => 1,
                'premium' => 1,
                'title' => 'The Role of Technology in Education','text' => 'Technology greatly influences education, transforming how knowledge is imparted and absorbed. Interactive whiteboards replace chalkboards, and digital textbooks offer in-depth, multimedia learning. Online courses democratize education, making it accessible irrespective of location. Collaborative tools foster group learning and cultivate global perspectives among students. Adaptive learning platforms personalize instruction based on a student\'s pace and understanding. However, with this digital transition comes the need for cybersecurity, digital literacy, and efforts to bridge the digital divide. Balancing these aspects ensures a constructive role for technology in education.','path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/5.+(American)+The+Role+of+Technology+in+Education.mp3',
                'sort_order' => 5,
                'enabled' => 0
            ],
            [
                'id' => 6,
                'dictation_topic_id' => 12,
                'language_variant_id' => 2,
                'premium' => 0,
                'title' => 'The Impact of Technology on Society','text' => 'Technology significantly shapes the way we interact, work, and think. It has turned the world into a global village by breaking down geographical boundaries. Our ability to send messages instantly, share thoughts online, and access vast information pools at the tap of a screen is nothing short of transformative. Nonetheless, it has also sparked debates on data privacy and mental health concerns. Balancing these opposing outcomes is a contemporary challenge, but the undeniable truth is that technology has woven itself into the very fabric of our society.','path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/1.+(British)+The+Impact+of+Technology+on+Society.mp3',
                'sort_order' => 1,
                'enabled' => 1
            ],
            [
                'id' => 7,
                'dictation_topic_id' => 12,
                'language_variant_id' => 2,
                'premium' => 1,
                'title' => 'How Technology is Revolutionizing Healthcare','text' => 'Technology is revolutionising healthcare in numerous ways. Advanced medical imaging has enhanced disease diagnosis, reducing the likelihood of invasive procedures. Electronic health records have streamlined patient data management, improving efficiency and care quality. Telemedicine brings medical consultation to patients\' homes, greatly benefitting those in remote areas. Furthermore, wearables monitor vital signs, enabling preventative care and lifestyle improvements. While there are potential issues such as data breaches and patient privacy, the positives largely outweigh the negatives. Technology in healthcare continues to bring life-saving advancements and improved quality of life.','path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/2.+(British)+How+Technology+is+Revolutionizing+Healthcare.mp3',
                'sort_order' => 2,
                'enabled' => 1
            ],
            [
                'id' => 8,
                'dictation_topic_id' => 12,
                'language_variant_id' => 2,
                'premium' => 1,
                'title' => 'The Future of Virtual Reality Technology','text' => 'The future of virtual reality technology is immensely promising, teeming with potential. It is becoming increasingly immersive, blurring the line between reality and virtual environments. This has profound implications for entertainment, education, and even mental health therapy. Imagine exploring far-flung historical sites from the comfort of your living room, or students visiting Mars virtually while learning about space exploration. Therapists could use virtual reality to safely expose patients to phobias, enabling effective treatment. While there are ethical concerns, with careful navigation, virtual reality can enrich our lives in unimaginable ways.','path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/3.+(British)+The+Future+of+Virtual+Reality+Technology.mp3',
                'sort_order' => 3,
                'enabled' => 1
            ],
            [
                'id' => 9,
                'dictation_topic_id' => 12,
                'language_variant_id' => 2,
                'premium' => 1,
                'title' => 'The Evolution of Smart Home Technology','text' => 'Smart home technology has come a long way from its early days. Originally focused on security and simple tasks like lighting control, it has evolved into an integral part of our lives. With voice-controlled assistants, we can manage schedules, control ambient conditions, and even cook meals. Energy efficiency is another vital area where smart homes shine. They help reduce our environmental footprint by optimising resource usage. Despite cybersecurity and privacy issues, with appropriate safeguards, smart home technology can provide convenience, security, and sustainability.','path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/4.+(British)+The+Evolution+of+Smart+Home+Technology.mp3',
                'sort_order' => 4,
                'enabled' => 1
            ],
            [
                'id' => 10,
                'dictation_topic_id' => 12,
                'language_variant_id' => 2,
                'premium' => 1,
                'title' => 'The Role of Technology in Education','text' => 'The role of technology in education has never been more significant. Digital platforms enable students to learn at their own pace, catering to individual needs. Virtual classrooms break down geographical barriers, allowing students from around the world to study together. Technology also provides myriad resources at our fingertips, encouraging independent research and critical thinking. Yet, it\'s important to address digital divide issues to ensure equal opportunities for all students. Though challenges persist, the potential of technology in fostering an inclusive, personalised, and interactive learning environment is immense.','path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/5.+(British)+The+Role+of+Technology+in+Education.mp3',
                'sort_order' => 5,
                'enabled' => 1
            ],
            [
                'id' => 11,
                'dictation_topic_id' => 3,
                'language_variant_id' => 1,
                'premium' => 0,
                'title' => 'Effective Business Communication','text' => 'Clear and concise communication is fundamental to successful business operations. All employees must cultivate strong skills to express their thoughts, ideas, and needs effectively. It involves speaking and writing with precision, listening with intent, and interpreting non-verbal cues. Acknowledging others\' opinions fosters a culture of respect and collaboration. Mastering the art of conversation helps build stronger relationships, improves problem-solving, and leads to better decision-making. For business success, excellent communication is not just desirable, it is absolutely essential.','path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/1.+(American)+Effective+Business+Communication.mp3',
                'sort_order' => 1,
                'enabled' => 1
            ],
            [
                'id' => 12,
                'dictation_topic_id' => 3,
                'language_variant_id' => 1,
                'premium' => 1,
                'title' => 'The Art of Negotiation in Business','text' => 'Negotiation in business requires a blend of strategic thinking, interpersonal skills, and understanding of human psychology. Parties discuss their needs, offering compromises to reach a mutually beneficial outcome. Preparation is key, as understanding the other side\'s perspective aids in framing compelling arguments. Diplomacy and tact help maintain relationships even during disagreements. Effective negotiators listen more than they speak, responding thoughtfully to concerns and queries. It\'s a dance of give and take, of persuasion and concession, leading to shared success.','path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/2.+(American)+The+Art+of+Negotiation+in+Business.mp3',
                'sort_order' => 2,
                'enabled' => 1
            ],
            [
                'id' => 13,
                'dictation_topic_id' => 3,
                'language_variant_id' => 1,
                'premium' => 1,
                'title' => 'Understanding Business Ethics','text' => 'Business ethics underpin all interactions and decisions in an organization. They guide how a company interacts with stakeholders, from employees to clients to society at large. Ethics ensure fairness, honesty, and integrity, providing a moral compass for businesses navigating complex issues. Companies must instill a culture of ethics, with leaders modeling behavior and employees holding each other accountable. Transparency, responsibility, and respect must permeate every decision, every interaction. This ethical commitment defines a company\'s character and reputation.','path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/3.+(American)+Understanding+Business+Ethics.mp3',
                'sort_order' => 3,
                'enabled' => 1
            ],
            [
                'id' => 14,
                'dictation_topic_id' => 3,
                'language_variant_id' => 1,
                'premium' => 1,
                'title' => 'Successful Business Presentations','text' => 'A successful business presentation requires planning, creativity, and delivery skills. The presenter should identify the purpose, understand the audience, and craft a compelling narrative. Presentations should be clear, concise, and engaging, with visual aids to support the message. Preparation, practice, and audience interaction enhance delivery. Confidence and enthusiasm can persuade listeners, making the presentation memorable. Ultimately, successful presentations inspire, inform, and initiate action, leaving a lasting impression and driving business success.','path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/4.+(American)+Successful+Business+Presentations.mp3',
                'sort_order' => 4,
                'enabled' => 1
            ],
            [
                'id' => 15,
                'dictation_topic_id' => 3,
                'language_variant_id' => 1,
                'premium' => 1,
                'title' => 'Business Writing Skills for Professionals','text' => 'Effective writing is a powerful tool for business professionals. It can persuade, instruct, inspire, and build relationships. Business writing needs to be clear, concise, and free of jargon, tailored to the intended audience. Whether crafting an email, a report, or a proposal, the message should be logical, well-structured, and free of errors. Words must convey precision and respect, enhancing credibility. Through thoughtful writing, professionals can demonstrate expertise, influence decisions, and drive business outcomes.','path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/5.+(American)+Business+Writing+Skills+for+Professionals.mp3',
                'sort_order' => 5,
                'enabled' => 1
            ],
            [
                'id' => 16,
                'dictation_topic_id' => 3,
                'language_variant_id' => 2,
                'premium' => 0,
                'title' => 'Effective Business Communication','text' => 'Good communication is the cornerstone of successful businesses. It enables clarity and avoids misunderstandings. People in business should listen actively, empathise with colleagues, and express ideas clearly. Assertive, not aggressive, language is key. Use plain English and avoid jargon. Tailoring your message to the audience ensures comprehension. Effective communication also means being responsive, recognising verbal and nonverbal cues, and providing constructive feedback. Through mastering these skills, one can build stronger relationships and foster an environment of cooperation and understanding.','path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/1.+(British)+Effective+Business+Communication.mp3',
                'sort_order' => 1,
                'enabled' => 1
            ],
            [
                'id' => 17,
                'dictation_topic_id' => 3,
                'language_variant_id' => 2,
                'premium' => 1,
                'title' => 'The Art of Negotiation in Business','text' => 'Negotiation is an art form in the world of business. It involves understanding needs, articulating wants, and finding common ground. Preparation is crucial; know your position, identify your bottom line, and anticipate potential outcomes. Be respectful and open to different perspectives. Equally important is listening. Listen more than you talk, understand the other party\'s viewpoint and respond empathetically. Patience can lead to better solutions. Remember, the goal is not to \'win\' the negotiation, but to create a mutually beneficial agreement.','path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/2.+(British)+The+Art+of+Negotiation+in+Business.mp3',
                'sort_order' => 2,
                'enabled' => 1
            ],
            [
                'id' => 18,
                'dictation_topic_id' => 3,
                'language_variant_id' => 2,
                'premium' => 1,
                'title' => 'Understanding Business Ethics','text' => 'Business ethics are fundamental in the corporate world. They guide companies in their decision-making processes, ensuring fairness and responsibility. Honesty and integrity should be at the forefront of all actions. Ethical businesses prioritise transparency, rejecting deceitful practices. They respect confidentiality and honour commitments. Additionally, they foster a culture of respect, appreciating the diversity of thoughts and ideas. Ethical conduct also extends to corporate responsibility, where businesses strive to minimise their environmental impact. An ethically driven business is not just about profit, but also contributing positively to society.','path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/3.+(British)+Understanding+Business+Ethics.mp3',
                'sort_order' => 3,
                'enabled' => 1
            ],
            [
                'id' => 19,
                'dictation_topic_id' => 3,
                'language_variant_id' => 2,
                'premium' => 1,
                'title' => 'Successful Business Presentations','text' => 'Delivering a successful business presentation requires preparation, clarity, and engagement. Start by understanding your audience\'s needs and expectations. Tailor your message to fit this understanding. Organise your thoughts and create a clear, logical flow. When presenting, articulate your words, modulate your voice and maintain eye contact. Use visual aids for better understanding, but do not let them overshadow your message. Practice beforehand to increase your confidence. Engage your audience, invite questions, and encourage participation. A well-delivered presentation leaves a lasting, positive impression.','path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/4.+(British)+Successful+Business+Presentations.mp3',
                'sort_order' => 4,
                'enabled' => 1
            ],
            [
                'id' => 20,
                'dictation_topic_id' => 3,
                'language_variant_id' => 2,
                'premium' => 1,
                'title' => 'Business Writing Skills for Professionals','text' => 'Professionals require strong writing skills in business. Written communication should be concise, clear, and free from spelling or grammatical errors. The tone should be professional yet approachable. When writing, identify your purpose and tailor your content to your audience\'s needs. Use simple, direct language and avoid unnecessary jargon. Structure your information logically, beginning with the most important points. Include an engaging introduction and a clear conclusion. Proofread your work before sending, ensuring your message is correctly understood. Skilful business writing can boost your professional image and effectiveness.','path_audio' => 'falsehttps://langboosterbucket.s3.amazonaws.com/staging/5.+(British)+Business+Writing+Skills+for+Professionals.mp3',
                'sort_order' => 5,
                'enabled' => 1
            ],
        ]);
    }
}
