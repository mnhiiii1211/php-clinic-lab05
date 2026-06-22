USE web_php_lab05_clinic;

INSERT INTO users (name, email, password_hash, role) VALUES
('Clinic Admin', 'admin.clinic@example.com', '$2y$10$examplehashadmin', 'admin'),
('Reception Staff', 'reception@example.com', '$2y$10$examplehashstaff', 'staff')
ON DUPLICATE KEY UPDATE name = VALUES(name);

INSERT INTO patients (name, email, phone, gender, note) VALUES
('Anna Nguyen', 'anna.patient@example.com', '0909000001', 'female', 'First visit, general checkup'),
('Ben Tran', 'ben.patient@example.com', '0909000002', 'male', 'Follow up for blood test'),
('Chris Le', 'chris.patient@example.com', '0909000003', 'male', 'Dental consultation'),
('Duyen Pham', 'duyen.patient@example.com', '0909000004', 'female', 'Eye examination'),
('Minh Ho', 'minh.patient@example.com', '0909000005', 'male', 'Annual checkup'),
('Linh Dao', 'linh.patient@example.com', '0909000006', 'female', 'Skin allergy consultation'),
('Tuan Vo', 'tuan.patient@example.com', '0909000007', 'male', 'Physical therapy'),
('Nhi Ly', 'nhi.patient@example.com', '0909000008', 'female', 'Vaccination schedule'),
('Khoa Phan', 'khoa.patient@example.com', '0909000009', 'male', 'Nutrition consultation'),
('Trang Bui', 'trang.patient@example.com', '0909000010', 'female', 'Headache follow up'),
('Huy Dang', 'huy.patient@example.com', '0909000011', 'male', 'Orthopedic consultation'),
('Mai Truong', 'mai.patient@example.com', '0909000012', 'female', 'General medicine'),
('Quang Lam', 'quang.patient@example.com', '0909000013', 'male', 'Cardiology screening'),
('Vy Nguyen', 'vy.patient@example.com', '0909000014', 'female', 'ENT consultation'),
('Nam Pham', 'nam.patient@example.com', '0909000015', 'male', 'Diabetes screening'),
('Hana Vo', 'hana.patient@example.com', '0909000016', 'other', 'New patient intake'),
('Long Do', 'long.patient@example.com', '0909000017', 'male', 'Return visit'),
('Thao Huynh', 'thao.patient@example.com', '0909000018', 'female', 'Checkup'),
('Bao Le', 'bao.patient@example.com', '0909000019', 'male', 'Lab result review'),
('Yen Tran', 'yen.patient@example.com', '0909000020', 'female', 'Dermatology consultation')
ON DUPLICATE KEY UPDATE name = VALUES(name), phone = VALUES(phone), gender = VALUES(gender), note = VALUES(note);

INSERT INTO appointments (appointment_code, patient_name, patient_email, appointment_date, status, note) VALUES
('APT-2026-0001', 'Anna Nguyen', 'anna.patient@example.com', '2026-06-22 09:00:00', 'scheduled', 'General checkup'),
('APT-2026-0002', 'Ben Tran', 'ben.patient@example.com', '2026-06-22 10:00:00', 'completed', 'Blood test follow up'),
('APT-2026-0003', 'Chris Le', 'chris.patient@example.com', '2026-06-22 11:00:00', 'cancelled', 'Cancelled by patient'),
('APT-2026-0004', 'Duyen Pham', 'duyen.patient@example.com', '2026-06-23 09:30:00', 'scheduled', 'Eye examination'),
('APT-2026-0005', 'Minh Ho', 'minh.patient@example.com', '2026-06-23 10:30:00', 'completed', 'Annual checkup'),
('APT-2026-0006', 'Linh Dao', 'linh.patient@example.com', '2026-06-23 14:00:00', 'scheduled', 'Skin allergy'),
('APT-2026-0007', 'Tuan Vo', 'tuan.patient@example.com', '2026-06-24 09:00:00', 'no_show', 'Patient did not arrive'),
('APT-2026-0008', 'Nhi Ly', 'nhi.patient@example.com', '2026-06-24 10:00:00', 'scheduled', 'Vaccination'),
('APT-2026-0009', 'Khoa Phan', 'khoa.patient@example.com', '2026-06-24 11:00:00', 'scheduled', 'Nutrition consultation'),
('APT-2026-0010', 'Trang Bui', 'trang.patient@example.com', '2026-06-25 09:00:00', 'completed', 'Headache follow up'),
('APT-2026-0011', 'Huy Dang', 'huy.patient@example.com', '2026-06-25 10:00:00', 'scheduled', 'Orthopedic consultation'),
('APT-2026-0012', 'Mai Truong', 'mai.patient@example.com', '2026-06-25 11:00:00', 'scheduled', 'General medicine'),
('APT-2026-0013', 'Quang Lam', 'quang.patient@example.com', '2026-06-26 09:30:00', 'completed', 'Cardiology screening'),
('APT-2026-0014', 'Vy Nguyen', 'vy.patient@example.com', '2026-06-26 10:30:00', 'scheduled', 'ENT consultation'),
('APT-2026-0015', 'Nam Pham', 'nam.patient@example.com', '2026-06-26 14:00:00', 'cancelled', 'Patient rescheduled'),
('APT-2026-0016', 'Hana Vo', 'hana.patient@example.com', '2026-06-27 09:00:00', 'scheduled', 'New patient intake'),
('APT-2026-0017', 'Long Do', 'long.patient@example.com', '2026-06-27 10:00:00', 'scheduled', 'Return visit'),
('APT-2026-0018', 'Thao Huynh', 'thao.patient@example.com', '2026-06-27 11:00:00', 'completed', 'Checkup'),
('APT-2026-0019', 'Bao Le', 'bao.patient@example.com', '2026-06-28 09:00:00', 'scheduled', 'Lab result review'),
('APT-2026-0020', 'Yen Tran', 'yen.patient@example.com', '2026-06-28 10:00:00', 'scheduled', 'Dermatology consultation')
ON DUPLICATE KEY UPDATE patient_name = VALUES(patient_name), patient_email = VALUES(patient_email), appointment_date = VALUES(appointment_date), status = VALUES(status), note = VALUES(note);
