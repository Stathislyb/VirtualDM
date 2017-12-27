-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 27, 2017 at 10:14 AM
-- Server version: 10.1.29-MariaDB
-- PHP Version: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `virtualdm`
--

-- --------------------------------------------------------

--
-- Table structure for table `event_meaning`
--

CREATE TABLE `event_meaning` (
  `id` int(11) NOT NULL,
  `title` varchar(500) NOT NULL,
  `weight` float NOT NULL DEFAULT '1',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `event_meaning`
--

INSERT INTO `event_meaning` (`id`, `title`, `weight`, `status`, `created_date`) VALUES
(1, 'Attainment of goals.', 1, 1, '2017-12-27 11:09:12'),
(2, 'The founding of a fellowship.', 1, 1, '2017-12-27 11:09:12'),
(3, 'Neglect of the environment.', 1, 1, '2017-12-27 11:09:12'),
(4, 'Blight.', 1, 1, '2017-12-27 11:09:12'),
(5, 'The beginning of an enterprise which may harm others.', 1, 1, '2017-12-27 11:09:12'),
(6, 'Ecstasy to the point of divorce from reality.', 1, 1, '2017-12-27 11:09:13'),
(7, 'Conquest by force.', 1, 1, '2017-12-27 11:09:13'),
(8, 'Macho excess.', 1, 1, '2017-12-27 11:09:13'),
(9, 'Willpower.', 1, 1, '2017-12-27 11:09:13'),
(10, 'The recruitment of allies.', 1, 1, '2017-12-27 11:09:13'),
(11, 'The triumph of an evil cause.', 1, 1, '2017-12-27 11:09:13'),
(12, 'Physical and emotional violation.', 1, 1, '2017-12-27 11:09:13'),
(13, 'Weakness in the face of opposition.', 1, 1, '2017-12-27 11:09:13'),
(14, 'Force applied with deliberate malice.', 1, 1, '2017-12-27 11:09:13'),
(15, 'A declaration of war.', 1, 1, '2017-12-27 11:09:13'),
(16, 'Persecution of the innocent.', 1, 1, '2017-12-27 11:09:13'),
(17, 'Love.', 1, 1, '2017-12-27 11:09:13'),
(18, 'Abandonment of the spiritual.', 1, 1, '2017-12-27 11:09:13'),
(19, 'Instant gratification.', 1, 1, '2017-12-27 11:09:13'),
(20, 'Intellectual inquiry.', 1, 1, '2017-12-27 11:09:13'),
(21, 'Antagonism towards new ideas.', 1, 1, '2017-12-27 11:09:13'),
(22, 'Joy and laughter.', 1, 1, '2017-12-27 11:09:13'),
(23, 'Written messages.', 1, 1, '2017-12-27 11:09:13'),
(24, 'Movement.', 1, 1, '2017-12-27 11:09:13'),
(25, 'Wasteful dispersal of energies.', 1, 1, '2017-12-27 11:09:13'),
(26, 'Truce.', 1, 1, '2017-12-27 11:09:13'),
(27, 'Balance disturbed.', 1, 1, '2017-12-27 11:09:13'),
(28, 'Tension released.', 1, 1, '2017-12-27 11:09:13'),
(29, 'Disloyalty.', 1, 1, '2017-12-27 11:09:13'),
(30, 'Friendship.', 1, 1, '2017-12-27 11:09:13'),
(31, 'Physical attraction.', 1, 1, '2017-12-27 11:09:13'),
(32, 'Love for the wrong reasons.', 1, 1, '2017-12-27 11:09:13'),
(33, 'Passion which interferes with judgment.', 1, 1, '2017-12-27 11:09:13'),
(34, 'A physical challenge.', 1, 1, '2017-12-27 11:09:13'),
(35, 'Desertion of a project.', 1, 1, '2017-12-27 11:09:13'),
(36, 'Domination.', 1, 1, '2017-12-27 11:09:13'),
(37, 'Procrastination.', 1, 1, '2017-12-27 11:09:13'),
(38, 'Acclaim.', 1, 1, '2017-12-27 11:09:13'),
(39, 'A journey which causes temporary separation.', 1, 1, '2017-12-27 11:09:13'),
(40, 'Loss.', 1, 1, '2017-12-27 11:09:13'),
(41, 'A matter concluded in plenty.', 1, 1, '2017-12-27 11:09:13'),
(42, 'Healing.', 1, 1, '2017-12-27 11:09:13'),
(43, 'Excessive devotion to the pleasures of the senses.', 1, 1, '2017-12-27 11:09:13'),
(44, 'Swiftness in bringing a matter to its conclusion.', 1, 1, '2017-12-27 11:09:13'),
(45, 'Delay in obtaining material possessions.', 1, 1, '2017-12-27 11:09:13'),
(46, 'Delay.', 1, 1, '2017-12-27 11:09:13'),
(47, 'Prosperity.', 1, 1, '2017-12-27 11:09:13'),
(48, 'Material difficulties.', 1, 1, '2017-12-27 11:09:13'),
(49, 'Cessation of benefits.', 1, 1, '2017-12-27 11:09:13'),
(50, 'Temporary companionship.', 1, 1, '2017-12-27 11:09:13'),
(51, 'Loss due to the machinations of another.', 1, 1, '2017-12-27 11:09:13'),
(52, 'Lies made public.', 1, 1, '2017-12-27 11:09:13'),
(53, 'Spite.', 1, 1, '2017-12-27 11:09:13'),
(54, 'A situation does not live up to expectations.', 1, 1, '2017-12-27 11:09:13'),
(55, 'Defeat.', 1, 1, '2017-12-27 11:09:13'),
(56, 'Return of an old friend.', 1, 1, '2017-12-27 11:09:13'),
(57, 'New alliances.', 1, 1, '2017-12-27 11:09:13'),
(58, 'Imitation of reality.', 1, 1, '2017-12-27 11:09:13'),
(59, 'Confusion in legal matters.', 1, 1, '2017-12-27 11:09:13'),
(60, 'Bureaucracy.', 1, 1, '2017-12-27 11:09:13'),
(61, 'Unfairness in a business matter.', 1, 1, '2017-12-27 11:09:13'),
(62, 'Journey by water.', 1, 1, '2017-12-27 11:09:13'),
(63, 'A path away from difficulties.', 1, 1, '2017-12-27 11:09:13'),
(64, 'A temporary respite in struggle.', 1, 1, '2017-12-27 11:09:13'),
(65, 'Stalemate.', 1, 1, '2017-12-27 11:09:13'),
(66, 'Publicity.', 1, 1, '2017-12-27 11:09:13'),
(67, 'Public recognition for one\'s efforts.', 1, 1, '2017-12-27 11:09:13'),
(68, 'Good news.', 1, 1, '2017-12-27 11:09:13'),
(69, 'Bad news.', 1, 1, '2017-12-27 11:09:13'),
(70, 'Indefinite postponement by another of a project.', 1, 1, '2017-12-27 11:09:13'),
(71, 'Cause for anxiety due to exterior factors.', 1, 1, '2017-12-27 11:09:13'),
(72, 'Delay in achieving one\'s goal.', 1, 1, '2017-12-27 11:09:13'),
(73, 'Theft.', 1, 1, '2017-12-27 11:09:13'),
(74, 'A journey by land.', 1, 1, '2017-12-27 11:09:13'),
(75, 'Good advice from an expert.', 1, 1, '2017-12-27 11:09:13'),
(76, 'The exposure and consequent failure of a plot.', 1, 1, '2017-12-27 11:09:13'),
(77, 'A project about to reach completion.', 1, 1, '2017-12-27 11:09:13'),
(78, 'Intellectual competition.', 1, 1, '2017-12-27 11:09:13'),
(79, 'Haggling.', 1, 1, '2017-12-27 11:09:13'),
(80, 'Imprisonment.', 1, 1, '2017-12-27 11:09:14'),
(81, 'Illness.', 1, 1, '2017-12-27 11:09:14'),
(82, 'Release.', 1, 1, '2017-12-27 11:09:14'),
(83, 'Opposition collapses.', 1, 1, '2017-12-27 11:09:14'),
(84, 'A matter believed to be of great importance is actually\n			of small consequence.', 1, 1, '2017-12-27 11:09:14'),
(85, 'Loss of interest.', 1, 1, '2017-12-27 11:09:14'),
(86, 'Celebration of a success.', 1, 1, '2017-12-27 11:09:14'),
(87, 'Rapid development of an undertaking.', 1, 1, '2017-12-27 11:09:14'),
(88, 'Travel by air.', 1, 1, '2017-12-27 11:09:14'),
(89, 'Non-arrival of an expected communication.', 1, 1, '2017-12-27 11:09:14'),
(90, 'Jealousy.', 1, 1, '2017-12-27 11:09:14'),
(91, 'Dispute among partners.', 1, 1, '2017-12-27 11:09:14'),
(92, 'A project does not work out.', 1, 1, '2017-12-27 11:09:14'),
(93, 'The possible loss of home.', 1, 1, '2017-12-27 11:09:14'),
(94, 'An investment proves worthless.', 1, 1, '2017-12-27 11:09:14'),
(95, 'Suffering.', 1, 1, '2017-12-27 11:09:14'),
(96, 'Mental imprisonment.', 1, 1, '2017-12-27 11:09:14'),
(97, 'Debasement.', 1, 1, '2017-12-27 11:09:14'),
(98, 'Material desires are wholly fulfilled.', 1, 1, '2017-12-27 11:09:14'),
(99, 'Overindulgence.', 1, 1, '2017-12-27 11:09:14'),
(100, 'Wishes fall short.', 1, 1, '2017-12-27 11:09:14'),
(101, 'Delaying tactics.', 1, 1, '2017-12-27 11:09:14'),
(102, 'Stalemate leading to adjournment.', 1, 1, '2017-12-27 11:09:14'),
(103, 'Adversity, but not insurmountable.', 1, 1, '2017-12-27 11:09:14'),
(104, 'Gambling.', 1, 1, '2017-12-27 11:09:14'),
(105, 'Lack of solidity.', 1, 1, '2017-12-27 11:09:14'),
(106, 'Misfortune.', 1, 1, '2017-12-27 11:09:14'),
(107, 'The death of a dream.', 1, 1, '2017-12-27 11:09:14'),
(108, 'Disruption.', 1, 1, '2017-12-27 11:09:14'),
(109, 'Temporary success.', 1, 1, '2017-12-27 11:09:14'),
(110, 'Usurped power.', 1, 1, '2017-12-27 11:09:14'),
(111, 'A balance is made, but it is temporary.', 1, 1, '2017-12-27 11:09:14'),
(112, 'Failure of a partnership.', 1, 1, '2017-12-27 11:09:14'),
(113, 'Possible loss of friendship.', 1, 1, '2017-12-27 11:09:14'),
(114, 'Betrayal.', 1, 1, '2017-12-27 11:09:14'),
(115, 'Abuse of power.', 1, 1, '2017-12-27 11:09:14'),
(116, 'Becoming a burden to another.', 1, 1, '2017-12-27 11:09:14'),
(117, 'Oppression of the few by the many.', 1, 1, '2017-12-27 11:09:14'),
(118, 'Intrigues.', 1, 1, '2017-12-27 11:09:14'),
(119, 'Resentment.', 1, 1, '2017-12-27 11:09:14'),
(120, 'Fears realized.', 1, 1, '2017-12-27 11:09:14'),
(121, 'A student.', 1, 1, '2017-12-27 11:09:14'),
(122, 'Messages.', 1, 1, '2017-12-27 11:09:14'),
(123, 'The bearer of bad news.', 1, 1, '2017-12-27 11:09:14'),
(124, 'Fears proven unfounded.', 1, 1, '2017-12-27 11:09:14'),
(125, 'A sentinel.', 1, 1, '2017-12-27 11:09:14'),
(126, 'Inspection or scrutiny.', 1, 1, '2017-12-27 11:09:14'),
(127, 'Ambush.', 1, 1, '2017-12-27 11:09:14'),
(128, 'Spying.', 1, 1, '2017-12-27 11:09:14'),
(129, 'Mutiny.', 1, 1, '2017-12-27 11:09:14'),
(130, 'News.', 1, 1, '2017-12-27 11:09:14'),
(131, 'Attachment to the point of obsession.', 1, 1, '2017-12-27 11:09:14'),
(132, 'The affairs of the world.', 1, 1, '2017-12-27 11:09:14'),
(133, 'Unexpected aid.', 1, 1, '2017-12-27 11:09:14'),
(134, 'A bearer of intelligence.', 1, 1, '2017-12-27 11:09:14'),
(135, 'Rumor.', 1, 1, '2017-12-27 11:09:14'),
(136, 'Old wounds reopened.', 1, 1, '2017-12-27 11:09:14'),
(137, 'Carelessness.', 1, 1, '2017-12-27 11:09:14'),
(138, 'Friendship strained.', 1, 1, '2017-12-27 11:09:14'),
(139, 'Guerrilla warfare.', 1, 1, '2017-12-27 11:09:14'),
(140, 'Ruin.', 1, 1, '2017-12-27 11:09:14'),
(141, 'Unwise extravagance.', 1, 1, '2017-12-27 11:09:14'),
(142, 'Dirty tricks.', 1, 1, '2017-12-27 11:09:14'),
(143, 'Arrival of a friend.', 1, 1, '2017-12-27 11:09:14'),
(144, 'Propositions.', 1, 1, '2017-12-27 11:09:14'),
(145, 'Fraud.', 1, 1, '2017-12-27 11:09:14'),
(146, 'Rivalry.', 1, 1, '2017-12-27 11:09:15'),
(147, 'A spiritual representative.', 1, 1, '2017-12-27 11:09:15'),
(148, 'Triumph over adversities.', 1, 1, '2017-12-27 11:09:15'),
(149, 'Travel by air.', 1, 1, '2017-12-27 11:09:15'),
(150, 'Frustration.', 1, 1, '2017-12-27 11:09:15'),
(151, 'Division.', 1, 1, '2017-12-27 11:09:15'),
(152, 'The refusal to listen to views at variance to one\'s own.', 1, 1, '2017-12-27 11:09:15'),
(153, 'Motherly figure.', 1, 1, '2017-12-27 11:09:15'),
(154, 'Opulence.', 1, 1, '2017-12-27 11:09:15'),
(155, 'Ill-natured gossip.', 1, 1, '2017-12-27 11:09:15'),
(156, 'Mistrust of those near.', 1, 1, '2017-12-27 11:09:15'),
(157, 'Liberty.', 1, 1, '2017-12-27 11:09:15'),
(158, 'Deceit.', 1, 1, '2017-12-27 11:09:15'),
(159, 'Cruelty from intolerance.', 1, 1, '2017-12-27 11:09:15'),
(160, 'A person not to be trusted.', 1, 1, '2017-12-27 11:09:15'),
(161, 'Excitement from activity.', 1, 1, '2017-12-27 11:09:15'),
(162, 'Someone of assistance.', 1, 1, '2017-12-27 11:09:15'),
(163, 'Father figure.', 1, 1, '2017-12-27 11:09:15'),
(164, 'A dull individual.', 1, 1, '2017-12-27 11:09:15'),
(165, 'Military.', 1, 1, '2017-12-27 11:09:15'),
(166, 'A judge.', 1, 1, '2017-12-27 11:09:15'),
(167, 'A wise counselor.', 1, 1, '2017-12-27 11:09:15'),
(168, 'The mundane.', 1, 1, '2017-12-27 11:09:15'),
(169, 'A teacher.', 1, 1, '2017-12-27 11:09:15'),
(170, 'Trials overcome.', 1, 1, '2017-12-27 11:09:15'),
(171, 'Frenzy.', 1, 1, '2017-12-27 11:09:15'),
(172, 'Negligence.', 1, 1, '2017-12-27 11:09:15'),
(173, 'Duality.', 1, 1, '2017-12-27 11:09:15'),
(174, 'Passion', 1, 1, '2017-12-27 11:09:15'),
(175, 'Hard work.', 1, 1, '2017-12-27 11:09:15'),
(176, 'The control of masses.', 1, 1, '2017-12-27 11:09:15'),
(177, 'Alliance as a formality, not sincere.', 1, 1, '2017-12-27 11:09:15'),
(178, 'Attraction to an object or person.', 1, 1, '2017-12-27 11:09:15'),
(179, 'Travel by vehicle.', 1, 1, '2017-12-27 11:09:15'),
(180, 'Success in an artistic or spiritual pursuit.', 1, 1, '2017-12-27 11:09:15'),
(181, 'Vengeance.', 1, 1, '2017-12-27 11:09:15'),
(182, 'An unethical victory.', 1, 1, '2017-12-27 11:09:15'),
(183, 'Judicial proceedings.', 1, 1, '2017-12-27 11:09:15'),
(184, 'Dispute.', 1, 1, '2017-12-27 11:09:15'),
(185, 'Legal punishment.', 1, 1, '2017-12-27 11:09:15'),
(186, 'Guidance from an elder.', 1, 1, '2017-12-27 11:09:15'),
(187, 'A journey.', 1, 1, '2017-12-27 11:09:15'),
(188, 'Good fortune.', 1, 1, '2017-12-27 11:09:15'),
(189, 'Too much of a good thing.', 1, 1, '2017-12-27 11:09:15'),
(190, 'The spiritual over the material.', 1, 1, '2017-12-27 11:09:15'),
(191, 'The material over the spiritual.', 1, 1, '2017-12-27 11:09:15'),
(192, 'Transformation and change.', 1, 1, '2017-12-27 11:09:15'),
(193, 'Disunion.', 1, 1, '2017-12-27 11:09:15'),
(194, 'Assessment of riches.', 1, 1, '2017-12-27 11:09:15'),
(195, 'Overthrow of the existing order.', 1, 1, '2017-12-27 11:09:15'),
(196, 'Communication by technological means.', 1, 1, '2017-12-27 11:09:15'),
(197, 'Oppression.', 1, 1, '2017-12-27 11:09:15'),
(198, 'Hope.', 1, 1, '2017-12-27 11:09:15'),
(199, 'Hope deceived, daydreams fail.', 1, 1, '2017-12-27 11:09:15'),
(200, 'Change of place.', 1, 1, '2017-12-27 11:09:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `event_meaning`
--
ALTER TABLE `event_meaning`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `event_meaning`
--
ALTER TABLE `event_meaning`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=201;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
