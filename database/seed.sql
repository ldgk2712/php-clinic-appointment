USE clinic_lab05;

INSERT INTO users (name, email, password_hash, role)
VALUES
('Clinic Admin', 'admin@clinic.test', '$2y$10$examplehashadmin', 'admin'),
('Reception Staff', 'reception@clinic.test', '$2y$10$examplehashstaff', 'staff');

INSERT INTO patients (name, email, phone, gender, status, note)
VALUES
('Anna Nguyen', 'anna.nguyen@clinic.test', '0909000001', 'female', 'active', 'New patient - general checkup'),
('Ben Tran', 'ben.tran@clinic.test', '0909000002', 'male', 'active', 'Follow-up dental care'),
('Chris Le', 'chris.le@clinic.test', '0909000003', 'male', 'active', 'Needs blood test'),
('Duyen Pham', 'duyen.pham@clinic.test', '0909000004', 'female', 'inactive', 'Moved to another clinic'),
('Minh Ho', 'minh.ho@clinic.test', '0909000005', 'male', 'active', 'Annual health check'),
('Linh Vo', 'linh.vo@clinic.test', '0909000006', 'female', 'active', 'Dermatology consultation'),
('Huy Phan', 'huy.phan@clinic.test', '0909000007', 'male', 'active', 'Back pain consultation'),
('Mai Dang', 'mai.dang@clinic.test', '0909000008', 'female', 'active', 'Eye checkup'),
('Tuan Bui', 'tuan.bui@clinic.test', '0909000009', 'male', 'inactive', 'Insurance pending'),
('Nhi Lam', 'nhi.lam@clinic.test', '0909000010', 'female', 'active', 'Pediatrics inquiry'),
('Khoa Do', 'khoa.do@clinic.test', '0909000011', 'male', 'active', 'General consultation'),
('Trang Ly', 'trang.ly@clinic.test', '0909000012', 'female', 'active', 'Nutrition advice'),
('Quang Vo', 'quang.vo@clinic.test', '0909000013', 'male', 'active', 'Cardiology check'),
('Thao Nguyen', 'thao.nguyen@clinic.test', '0909000014', 'female', 'active', 'ENT consultation'),
('Bao Tran', 'bao.tran@clinic.test', '0909000015', 'male', 'active', 'Vaccination schedule'),
('Hoa Le', 'hoa.le@clinic.test', '0909000016', 'female', 'active', 'General checkup');

INSERT INTO appointments (appointment_code, patient_name, patient_email, appointment_date, department, status, note)
VALUES
('APT-2026-0001', 'Anna Nguyen', 'anna.nguyen@clinic.test', '2026-06-25 09:00:00', 'General', 'scheduled', 'First visit'),
('APT-2026-0002', 'Ben Tran', 'ben.tran@clinic.test', '2026-06-25 10:00:00', 'Dental', 'confirmed', 'Dental cleaning'),
('APT-2026-0003', 'Chris Le', 'chris.le@clinic.test', '2026-06-26 08:30:00', 'Laboratory', 'scheduled', 'Blood test'),
('APT-2026-0004', 'Duyen Pham', 'duyen.pham@clinic.test', '2026-06-26 14:00:00', 'General', 'cancelled', 'Patient cancelled'),
('APT-2026-0005', 'Minh Ho', 'minh.ho@clinic.test', '2026-06-27 09:30:00', 'General', 'completed', 'Annual check'),
('APT-2026-0006', 'Linh Vo', 'linh.vo@clinic.test', '2026-06-27 11:00:00', 'Dermatology', 'scheduled', 'Skin issue'),
('APT-2026-0007', 'Huy Phan', 'huy.phan@clinic.test', '2026-06-28 15:00:00', 'Orthopedics', 'confirmed', 'Back pain'),
('APT-2026-0008', 'Mai Dang', 'mai.dang@clinic.test', '2026-06-29 09:00:00', 'Ophthalmology', 'scheduled', 'Eye check'),
('APT-2026-0009', 'Tuan Bui', 'tuan.bui@clinic.test', '2026-06-29 13:30:00', 'General', 'cancelled', 'Insurance issue'),
('APT-2026-0010', 'Nhi Lam', 'nhi.lam@clinic.test', '2026-06-30 08:00:00', 'Pediatrics', 'scheduled', 'Child health check'),
('APT-2026-0011', 'Khoa Do', 'khoa.do@clinic.test', '2026-06-30 10:30:00', 'General', 'confirmed', 'General consultation'),
('APT-2026-0012', 'Trang Ly', 'trang.ly@clinic.test', '2026-07-01 09:30:00', 'Nutrition', 'scheduled', 'Diet plan'),
('APT-2026-0013', 'Quang Vo', 'quang.vo@clinic.test', '2026-07-01 14:30:00', 'Cardiology', 'confirmed', 'Heart check'),
('APT-2026-0014', 'Thao Nguyen', 'thao.nguyen@clinic.test', '2026-07-02 10:00:00', 'ENT', 'scheduled', 'Ear pain'),
('APT-2026-0015', 'Bao Tran', 'bao.tran@clinic.test', '2026-07-02 16:00:00', 'Vaccination', 'scheduled', 'Vaccination'),
('APT-2026-0016', 'Hoa Le', 'hoa.le@clinic.test', '2026-07-03 08:30:00', 'General', 'confirmed', 'General checkup');
