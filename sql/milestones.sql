INSERT INTO educational_institution_accreditation.milestones
(criteria_id, code, `order`, name)
VALUES
-- Tiêu chí 1.1
('1.1', '1.1.1', 1, 'CSGD có tuyên bố chính thức về tầm nhìn, sứ mạng.'),
('1.1', '1.1.2', 2, 'Có sự tham gia của các bên liên quan (cán bộ quản lý, GV, NH, nhà sử dụng lao động, các tổ chức xã hội-nghề nghiệp, ...) trong quá trình xây dựng tầm nhìn, sứ mạng.'),
('1.1', '1.1.3', 3, 'Nội dung tuyên bố về tầm nhìn, sứ mạng phù hợp với chức năng, nhiệm vụ, nguồn lực và định hướng phát triển của CSGD; phù hợp với chiến lược phát triển kinh tế-xã hội của ngành và/hoặc địa phương, cả nước.'),
('1.1', '1.1.4', 4, 'Lãnh đạo CSGD có các kế hoạch, hướng dẫn các đơn vị xây dựng và triển khai các hoạt động theo tầm nhìn, sứ mạng đã được xác định.'),

-- Tiêu chí 1.2
('1.2', '1.2.1', 1, 'CSGD có công bố chính thức giá trị văn hóa/giá trị cốt lõi của CSGD.'),
('1.2', '1.2.2', 2, 'Giá trị văn hóa/giá trị cốt lõi của CSGD được xác định từ các giá trị/truyền thống của CSGD nhằm thúc đẩy các hành vi mong muốn để đạt được mục tiêu chiến lược, phù hợp với tầm nhìn, sứ mạng.'),
('1.2', '1.2.3', 3, 'Lãnh đạo CSGD xây dựng kế hoạch nhằm phổ biến và hướng dẫn các đơn vị, cá nhân trong CSGD xây dựng kế hoạch hoạt động cụ thể để giữ gìn và phát triển giá trị văn hóa/giá trị cốt lõi của CSGD.'),

-- Tiêu chí 1.3
('1.3', '1.3.1', 1, 'CSGD có truyền thông, phổ biến về tầm nhìn, sứ mạng và văn hóa đến các bên liên quan.'),
('1.3', '1.3.2', 2, 'Tầm nhìn, sứ mạng và văn hóa của CSGD được quán triệt và giải thích rõ ràng cho các bên liên quan trong CSGD để thực hiện.'),

-- Tiêu chí 1.4
('1.4', '1.4.1', 1, 'Có đơn vị, bộ phận chịu trách nhiệm triển khai thực hiện việc rà soát tầm nhìn, sứ mạng và văn hóa của CSGD.'),
('1.4', '1.4.2', 2, 'CSGD tổ chức lấy ý kiến của các bên liên quan để điều chỉnh tầm nhìn, sứ mạng và văn hóa ít nhất một lần trong 5 năm của chu kỳ đánh giá nhằm đáp ứng nhu cầu và sự hài lòng của các bên liên quan.'),
('1.4', '1.4.3', 3, 'Có báo cáo kết quả rà soát về tầm nhìn, sứ mạng và giá trị cốt lõi của CSGD.'),

-- Tiêu chí 1.5
('1.5', '1.5.1', 1, 'CSGD có quy trình và đơn vị/bộ phận giám sát, rà soát, triển khai cải tiến chất lượng việc xây dựng, rà soát và phát triển tầm nhìn, sứ mạng và văn hóa.'),
('1.5', '1.5.2', 2, 'Tầm nhìn, sứ mạng và văn hóa của CSGD được điều chỉnh nhằm đáp ứng nhu cầu và sự hài lòng của các bên liên quan.'),
('1.5', '1.5.3', 3, 'Quy trình xây dựng, rà soát và phát triển tầm nhìn, sứ mạng và văn hóa được cải tiến ít nhất một lần trong 5 năm của chu kỳ đánh giá.'),


-- Tiêu chí 2.1
('2.1', '2.1.1', 1, 'CSGD có thành lập hội đồng quản trị/hội đồng trường; có các tổ chức đảng, đoàn thể, các hội đồng tư vấn đáp ứng quy định của Luật Giáo dục, Luật Giáo dục đại học, Điều lệ trường đại học, các quy định khác của pháp luật và các quy định của đơn vị chủ quản.'),
('2.1', '2.1.2', 2, 'Hội đồng quản trị/hội đồng trường; các tổ chức đảng, đoàn thể; các hội đồng tư vấn được quy định rõ chức năng, nhiệm vụ, quyền hạn; có các văn bản thể hiện trách nhiệm giải trình, tính bền vững, sự minh bạch và giảm thiểu các rủi ro tiềm tàng trong quá trình hoạt động.'),
('2.1', '2.1.3', 3, 'Có hệ thống văn bản để tổ chức, quản lý một cách có hiệu quả các hoạt động của CSGD.'),

-- Tiêu chí 2.2
('2.2', '2.2.1', 1, 'Các nghị quyết/quyết định/kết luận của Đảng ủy, hội đồng quản trị/hội đồng trường, Ban giám hiệu, Công đoàn, Đoàn thanh niên, Hội sinh viên và các tổ chức đoàn thể khác, các hội đồng tư vấn được chuyển tải thành các kế hoạch hành động, chính sách, hướng dẫn.'),
('2.2', '2.2.2', 2, 'Các kế hoạch hành động, chính sách, hướng dẫn được triển khai thực hiện.'),

-- Tiêu chí 2.3
('2.3', '2.3.1', 1, 'Định kỳ hằng năm rà soát, đánh giá cơ cấu tổ chức, chức năng, nhiệm vụ của các đơn vị, bộ phận và các văn bản của hệ thống quản trị.'),
('2.3', '2.3.2', 2, 'Có báo cáo tổng kết, đánh giá hằng năm của các đơn vị, bộ phận của hệ thống quản trị.'),
('2.3', '2.3.3', 3, 'Nhân sự tham gia các đơn vị, bộ phận trong hệ thống quản trị và các văn bản của hệ thống quản trị được đánh giá hằng năm.'),

-- Tiêu chí 2.4
('2.4', '2.4.1', 1, 'Cơ cấu tổ chức, chức năng, nhiệm vụ của các đơn vị, bộ phận được điều chỉnh phù hợp với các quy định của CSGD và các quy định khác của đơn vị chủ quản để tăng hiệu quả hoạt động và quản lý rủi ro tốt hơn.'),
('2.4', '2.4.2', 2, 'Nhân sự tham gia các đơn vị, bộ phận của hệ thống quản trị được điều chỉnh và/hoặc được nâng cao năng lực để tăng hiệu quả hoạt động và quản lý rủi ro tốt hơn.'),
('2.4', '2.4.3', 3, 'Hệ thống văn bản để tổ chức, quản lý của CSGD được điều chỉnh phù hợp với các thay đổi trong cơ cấu tổ chức và quản trị của CSGD.'),


-- Tiêu chí 3.1
('3.1', '3.1.1', 1, 'CSGD có cơ cấu quản lý rõ ràng; các đơn vị, bộ phận, tổ chức được thành lập mới căn cứ trên kế hoạch và định hướng chiến lược phát triển đã được phê duyệt, phù hợp với bối cảnh cụ thể của CSGD.'),
('3.1', '3.1.2', 2, 'Có văn bản quy định rõ ràng vai trò, trách nhiệm, chức năng, nhiệm vụ và mối liên hệ giữa các thành phần trong cơ cấu quản lý của CSGD.'),
('3.1', '3.1.3', 3, 'Nhân sự tham gia cơ cấu quản lý được phân định rõ vai trò, trách nhiệm, thẩm quyền ra quyết định, chế độ thông tin và báo cáo.'),

-- Tiêu chí 3.2
('3.2', '3.2.1', 1, 'Lãnh đạo CSGD tham gia kết nối, tuyên truyền và định hướng tầm nhìn, sứ mạng, giá trị cốt lõi và các mục tiêu chiến lược của CSGD.'),
('3.2', '3.2.2', 2, 'Lãnh đạo CSGD tổ chức các hoạt động tuyên truyền về tầm nhìn, sứ mạng, giá trị cốt lõi và các mục tiêu chiến lược của CSGD đến các bên liên quan.'),

-- Tiêu chí 3.3
('3.3', '3.3.1', 1, 'Cơ cấu quản lý của CSGD được định kỳ rà soát.'),
('3.3', '3.3.2', 2, 'Các văn bản quy định về vai trò, chức năng, nhiệm vụ và mối liên hệ giữa các thành phần trong cơ cấu quản lý được định kỳ rà soát.'),
('3.3', '3.3.3', 3, 'Nhân sự tham gia vào cơ cấu lãnh đạo và quản lý của CSGD được đánh giá định kỳ hằng năm.'),
('3.3', '3.3.4', 4, 'CSGD thực hiện quy hoạch đội ngũ lãnh đạo, quản lý của các đơn vị, bộ phận theo quy định.'),

-- Tiêu chí 3.4
('3.4', '3.4.1', 1, 'Cơ cấu lãnh đạo và quản lý của CSGD được cải tiến dựa trên kết quả rà soát và đánh giá.'),
('3.4', '3.4.2', 2, 'Các văn bản quy định về vai trò, chức năng, nhiệm vụ và mối liên hệ giữa các thành phần trong cơ cấu quản lý được điều chỉnh, bổ sung nhằm tăng hiệu quả quản lý và hiệu quả công việc của CSGD.'),
('3.4', '3.4.3', 3, 'Nhân sự tham gia cơ cấu lãnh đạo và quản lý của CSGD được điều chỉnh, luân chuyển dựa trên kết quả đánh giá năng lực lãnh đạo, quản lý và hiệu quả công việc.'),


-- Tiêu chí 4.1
('4.1', '4.1.1', 1, 'CSGD có bộ phận phụ trách công tác xây dựng và theo dõi kế hoạch chiến lược của CSGD.'),
('4.1', '4.1.2', 2, 'CSGD có quy trình hoặc hướng dẫn xây dựng kế hoạch chiến lược tổng thể và kế hoạch chiến lược theo từng lĩnh vực như nguồn nhân lực, cơ sở vật chất, tài chính, đào tạo, NCKH và phục vụ cộng đồng.'),
('4.1', '4.1.3', 3, 'Kế hoạch chiến lược của CSGD được xây dựng, ban hành và còn hiệu lực; phù hợp với tầm nhìn, sứ mạng, giá trị cốt lõi và các mục tiêu chiến lược về đào tạo, NCKH và phục vụ cộng đồng.'),

-- Tiêu chí 4.2
('4.2', '4.2.1', 1, 'CSGD có các kế hoạch ngắn hạn và dài hạn cụ thể hóa kế hoạch chiến lược theo từng lĩnh vực như nguồn nhân lực, cơ sở vật chất, tài chính, đào tạo, NCKH và phục vụ cộng đồng; các kế hoạch được ban hành và còn hiệu lực.'),
('4.2', '4.2.2', 2, 'Kế hoạch chiến lược và các kế hoạch ngắn hạn, dài hạn theo từng lĩnh vực được công bố, phổ biến để các bên liên quan biết và thực hiện.'),
('4.2', '4.2.3', 3, 'Các đơn vị, bộ phận, khoa và bộ môn cụ thể hóa và triển khai các hoạt động nhằm hoàn thành kế hoạch chiến lược và các kế hoạch ngắn hạn, dài hạn.'),

-- Tiêu chí 4.3
('4.3', '4.3.1', 1, 'CSGD xây dựng các KPIs và các chỉ tiêu phấn đấu chính trong các lĩnh vực như nguồn nhân lực, cơ sở vật chất, tài chính, đào tạo, NCKH và phục vụ cộng đồng.'),
('4.3', '4.3.2', 2, 'Các KPIs và các chỉ tiêu phấn đấu chính đảm bảo rõ ràng, đo lường được, có tính khả thi, phù hợp và có mốc thời gian thực hiện.'),
('4.3', '4.3.3', 3, 'CSGD thực hiện giám sát, đánh giá và rà soát mức độ thực hiện các chỉ số, chỉ báo và các chỉ tiêu phấn đấu chính so với các mục tiêu chiến lược.'),

-- Tiêu chí 4.4
('4.4', '4.4.1', 1, 'CSGD thực hiện cải tiến quá trình lập kế hoạch chiến lược nhằm đạt được các mục tiêu chiến lược đã đề ra.'),
('4.4', '4.4.2', 2, 'CSGD thực hiện đối sánh và đánh giá việc xây dựng, triển khai kế hoạch chiến lược để đề xuất các giải pháp thực hiện và điều chỉnh phù hợp nhằm đạt mục tiêu chiến lược.'),
('4.4', '4.4.3', 3, 'CSGD ban hành các văn bản bổ sung và điều chỉnh kế hoạch chiến lược, các KPIs và các chỉ tiêu phấn đấu chính.'),


-- Tiêu chí 5.1
('5.1', '5.1.1', 1, 'CSGD có phân công các đơn vị, bộ phận chịu trách nhiệm xây dựng các chính sách về đào tạo, NCKH và phục vụ cộng đồng.'),
('5.1', '5.1.2', 2, 'CSGD có văn bản hướng dẫn và kế hoạch tập huấn về việc xây dựng các chính sách về đào tạo, NCKH và phục vụ cộng đồng.'),
('5.1', '5.1.3', 3, 'Nội dung các chính sách về đào tạo, NCKH và phục vụ cộng đồng phù hợp với chủ trương của Đảng, quy định của Nhà nước; đáp ứng các yêu cầu của Luật Giáo dục, Luật Giáo dục đại học, Điều lệ trường đại học, các thông tư và hướng dẫn của Bộ Giáo dục và Đào tạo; phù hợp với sứ mạng và mục tiêu chiến lược của CSGD.'),
('5.1', '5.1.4', 4, 'Các chính sách về đào tạo, NCKH và phục vụ cộng đồng được lấy ý kiến các bên liên quan, được cụ thể hóa bằng văn bản và được lãnh đạo CSGD phê duyệt, ban hành để triển khai thực hiện.'),

-- Tiêu chí 5.2
('5.2', '5.2.1', 1, 'CSGD có phân công đơn vị, bộ phận chịu trách nhiệm theo dõi và giám sát việc thực hiện các chính sách về đào tạo, NCKH và phục vụ cộng đồng.'),
('5.2', '5.2.2', 2, 'CSGD ban hành văn bản quy định về quy trình giám sát sự tuân thủ các chính sách về đào tạo, NCKH và phục vụ cộng đồng.'),
('5.2', '5.2.3', 3, 'CSGD phổ biến các quy định về theo dõi và giám sát việc thực hiện các chính sách về đào tạo, NCKH và phục vụ cộng đồng.'),
('5.2', '5.2.4', 4, 'Định kỳ hằng năm, CSGD có báo cáo về việc triển khai và giám sát thực hiện các chính sách về đào tạo, NCKH và phục vụ cộng đồng.'),

-- Tiêu chí 5.3
('5.3', '5.3.1', 1, 'CSGD có quy định về việc định kỳ rà soát các chính sách về đào tạo, NCKH và phục vụ cộng đồng.'),
('5.3', '5.3.2', 2, 'CSGD định kỳ hằng năm thực hiện rà soát và đánh giá việc thực hiện các chính sách về đào tạo, NCKH và phục vụ cộng đồng theo kế hoạch.'),

-- Tiêu chí 5.4
('5.4', '5.4.1', 1, 'CSGD thực hiện cải tiến và điều chỉnh các chính sách về đào tạo, NCKH và phục vụ cộng đồng dựa trên kết quả rà soát và đánh giá.'),
('5.4', '5.4.2', 2, 'Các bên liên quan hài lòng đối với các chính sách về đào tạo, NCKH và phục vụ cộng đồng.'),


-- Tiêu chí 6.1
('6.1', '6.1.1', 1, 'CSGD có kế hoạch đánh giá nhu cầu về nguồn nhân lực đáp ứng hoạt động đào tạo, NCKH và phục vụ cộng đồng.'),
('6.1', '6.1.2', 2, 'CSGD có quy hoạch và kế hoạch phát triển nguồn nhân lực dựa trên đánh giá nhu cầu của hoạt động đào tạo, NCKH và phục vụ cộng đồng, tuân thủ các quy định hiện hành.'),

-- Tiêu chí 6.2
('6.2', '6.2.1', 1, 'CSGD có văn bản quy định về quy trình và tiêu chí tuyển dụng, lựa chọn đội ngũ cán bộ, GV, nhân viên đáp ứng các quy định hiện hành.'),
('6.2', '6.2.2', 2, 'CSGD có văn bản quy định về các tiêu chí đề bạt, bổ nhiệm và sắp xếp nhân sự.'),
('6.2', '6.2.3', 3, 'Các văn bản quy định về tiêu chí và quy trình tuyển dụng, bổ nhiệm và sắp xếp nhân sự được phổ biến rộng rãi bằng nhiều hình thức khác nhau.'),

-- Tiêu chí 6.3
('6.3', '6.3.1', 1, 'CSGD có bản mô tả các năng lực, bao gồm cả kỹ năng lãnh đạo, đối với các nhóm cán bộ, GV và nhân viên khác nhau.'),
('6.3', '6.3.2', 2, 'CSGD có văn bản quy định về các tiêu chuẩn năng lực, bao gồm cả kỹ năng lãnh đạo, của đội ngũ cán bộ, GV và nhân viên.'),

-- Tiêu chí 6.4
('6.4', '6.4.1', 1, 'CSGD có quy trình xác định nhu cầu đào tạo và bồi dưỡng của cán bộ, GV và nhân viên ở các cấp.'),
('6.4', '6.4.2', 2, 'Kế hoạch đào tạo, bồi dưỡng và phát triển chuyên môn được xây dựng dựa trên yêu cầu của hoạt động đào tạo, NCKH, nhu cầu phát triển chuyên môn của đội ngũ và phù hợp với kế hoạch chiến lược phát triển của CSGD.'),
('6.4', '6.4.3', 3, 'Các kế hoạch đào tạo, bồi dưỡng và phát triển chuyên môn của đội ngũ cán bộ, GV và nhân viên được triển khai thực hiện.'),
('6.4', '6.4.4', 4, 'Đội ngũ cán bộ, GV và nhân viên được đào tạo, bồi dưỡng và phát triển chuyên môn trung bình ít nhất một lượt trong 5 năm của chu kỳ đánh giá.'),

-- Tiêu chí 6.5
('6.5', '6.5.1', 1, 'CSGD xây dựng quy trình và tiêu chí rõ ràng để đánh giá hiệu quả công việc của cán bộ, GV và nhân viên.'),
('6.5', '6.5.2', 2, 'Việc đánh giá kết quả công việc của cán bộ, GV và nhân viên được thực hiện công khai và minh bạch.'),
('6.5', '6.5.3', 3, 'CSGD có dữ liệu và báo cáo kết quả đánh giá hiệu quả công việc của cán bộ, GV và nhân viên.'),
('6.5', '6.5.4', 4, 'Kết quả đánh giá được sử dụng trong công tác thi đua, khen thưởng và công nhận của CSGD và các cấp có thẩm quyền.'),
('6.5', '6.5.5', 5, 'Kết quả đánh giá được sử dụng làm căn cứ xác định đầu tư cho đào tạo, bồi dưỡng nhằm hỗ trợ hoạt động đào tạo, NCKH và phục vụ cộng đồng.'),

-- Tiêu chí 6.6
('6.6', '6.6.1', 1, 'Chế độ, chính sách, quy trình và quy hoạch về nguồn nhân lực của CSGD được rà soát hằng năm.'),
('6.6', '6.6.2', 2, 'Việc rà soát và đánh giá chế độ, chính sách, quy trình và quy hoạch về nguồn nhân lực căn cứ trên ý kiến đánh giá của cán bộ, GV và nhân viên.'),

-- Tiêu chí 6.7
('6.7', '6.7.1', 1, 'CSGD thực hiện cải thiện các chế độ và chính sách dựa trên kết quả rà soát và đánh giá nhằm hỗ trợ hoạt động đào tạo, NCKH và phục vụ cộng đồng.'),
('6.7', '6.7.2', 2, 'CSGD thực hiện cải tiến quy trình và quy hoạch về nguồn nhân lực làm căn cứ đầu tư cho phát triển nguồn nhân lực.'),



-- Tiêu chí 7.1
('7.1', '7.1.1', 1, 'CSGD có bộ phận xây dựng kế hoạch và theo dõi, giám sát việc phát triển các nguồn lực tài chính phục vụ đào tạo, NCKH và phục vụ cộng đồng.'),
('7.1', '7.1.2', 2, 'CSGD ban hành và triển khai các văn bản chiến lược, kế hoạch dài hạn, trung hạn và ngắn hạn nhằm tạo nguồn tài chính hợp pháp hỗ trợ thực hiện tầm nhìn, sứ mạng và mục tiêu chiến lược.'),
('7.1', '7.1.3', 3, 'Kế hoạch tài chính và quản lý tài chính được xây dựng căn cứ theo các quy định về tài chính, kế toán, kiểm toán, ngân sách và đấu thầu.'),
('7.1', '7.1.4', 4, 'Các kế hoạch tài chính, kiểm toán và tăng cường nguồn lực được triển khai thực hiện.'),
('7.1', '7.1.5', 5, 'Các kế hoạch tài chính được rà soát, đánh giá và cập nhật hằng năm; cơ cấu nguồn thu, chi được rà soát trong chu kỳ 5 năm.'),

-- Tiêu chí 7.2
('7.2', '7.2.1', 1, 'CSGD có bộ phận xây dựng và giám sát thực hiện kế hoạch đầu tư, bảo trì, đánh giá và nâng cấp cơ sở vật chất và hạ tầng phục vụ đào tạo, NCKH và phục vụ cộng đồng.'),
('7.2', '7.2.2', 2, 'CSGD ban hành các kế hoạch đầu tư, bảo trì, đánh giá và nâng cấp cơ sở vật chất, phòng thí nghiệm và thiết bị.'),
('7.2', '7.2.3', 3, 'Cơ sở vật chất, hạ tầng, phương tiện dạy học và thiết bị được đầu tư và bảo trì theo kế hoạch đã ban hành.'),
('7.2', '7.2.4', 4, 'Các kế hoạch về cơ sở vật chất và hạ tầng được thực hiện và rà soát, đánh giá hằng năm.'),
('7.2', '7.2.5', 5, 'CSGD có dữ liệu theo dõi và đánh giá hiệu quả sử dụng cơ sở vật chất, hạ tầng và thiết bị theo từng loại hình hoạt động.'),
('7.2', '7.2.6', 6, 'CSGD thực hiện cải tiến cơ sở vật chất và hạ tầng nhằm nâng cao hiệu quả phục vụ đào tạo, NCKH và phục vụ cộng đồng.'),

-- Tiêu chí 7.3
('7.3', '7.3.1', 1, 'CSGD có bộ phận quản trị thiết bị công nghệ thông tin và cơ sở hạ tầng.'),
('7.3', '7.3.2', 2, 'CSGD ban hành các kế hoạch đầu tư thiết bị công nghệ thông tin và hạ tầng như máy tính, hệ thống mạng, dự phòng, bảo mật và quyền truy cập.'),
('7.3', '7.3.3', 3, 'CSGD đầu tư mới và bảo trì thiết bị công nghệ thông tin và cơ sở hạ tầng theo kế hoạch.'),
('7.3', '7.3.4', 4, 'Thiết bị công nghệ thông tin và hạ tầng được rà soát và đánh giá hiệu quả đầu tư hằng năm.'),
('7.3', '7.3.5', 5, 'CSGD có dữ liệu theo dõi và đánh giá hiệu quả sử dụng thiết bị công nghệ thông tin và hạ tầng.'),
('7.3', '7.3.6', 6, 'CSGD nâng cấp và cải tiến hệ thống công nghệ thông tin và hạ tầng đáp ứng nhu cầu đào tạo, NCKH và phục vụ cộng đồng.'),

-- Tiêu chí 7.4
('7.4', '7.4.1', 1, 'CSGD có bộ phận quản trị nguồn lực học tập.'),
('7.4', '7.4.2', 2, 'CSGD ban hành các kế hoạch đầu tư và bảo trì nguồn lực học tập như học liệu thư viện, thiết bị giảng dạy và cơ sở dữ liệu trực tuyến.'),
('7.4', '7.4.3', 3, 'CSGD đầu tư mới và bảo trì nguồn lực học tập nhằm đáp ứng nhu cầu đào tạo, NCKH và phục vụ cộng đồng.'),
('7.4', '7.4.4', 4, 'Nguồn lực học tập được rà soát và đánh giá hiệu quả đầu tư, bảo trì hằng năm.'),
('7.4', '7.4.5', 5, 'CSGD có dữ liệu theo dõi và đánh giá hiệu quả sử dụng các nguồn lực học tập.'),
('7.4', '7.4.6', 6, 'Nguồn lực học tập được cập nhật và cải tiến nhằm nâng cao hiệu quả sử dụng.'),

-- Tiêu chí 7.5
('7.5', '7.5.1', 1, 'CSGD có bộ phận hoặc cá nhân phụ trách quản trị môi trường, sức khỏe, an toàn và khả năng tiếp cận của người có nhu cầu đặc biệt.'),
('7.5', '7.5.2', 2, 'CSGD ban hành các kế hoạch đầu tư về môi trường, sức khỏe, an toàn và khả năng tiếp cận.'),
('7.5', '7.5.3', 3, 'CSGD thực hiện đầu tư cho môi trường, sức khỏe, an toàn và khả năng tiếp cận.'),
('7.5', '7.5.4', 4, 'Các nội dung về môi trường, sức khỏe, an toàn và khả năng tiếp cận được rà soát, đánh giá hằng năm.'),
('7.5', '7.5.5', 5, 'CSGD có dữ liệu theo dõi và đánh giá hiệu quả đầu tư cải tiến môi trường, sức khỏe, an toàn và khả năng tiếp cận.'),
('7.5', '7.5.6', 6, 'Môi trường, sức khỏe, an toàn và khả năng tiếp cận được cải tiến sau mỗi đợt rà soát, đánh giá.'),



-- Tiêu chí 8.1
('8.1', '8.1.1', 1, 'CSGD có bộ phận chịu trách nhiệm xây dựng kế hoạch và theo dõi, giám sát các hoạt động đối ngoại theo quy định.'),
('8.1', '8.1.2', 2, 'CSGD ban hành văn bản quản lý hoạt động đối ngoại; có kế hoạch phát triển đối tác và mạng lưới phù hợp với tầm nhìn, sứ mạng và mục tiêu chiến lược; có quy định về cơ chế quản lý, kiểm tra, giám sát và phân cấp trong hoạt động đối ngoại.'),
('8.1', '8.1.3', 3, 'Kế hoạch phát triển đối tác, mạng lưới và quan hệ đối ngoại được phổ biến đến các bên liên quan trong CSGD.'),

-- Tiêu chí 8.2
('8.2', '8.2.1', 1, 'CSGD triển khai các hoạt động đối ngoại theo kế hoạch và thực hiện các thỏa thuận đã ký kết.'),
('8.2', '8.2.2', 2, 'CSGD triển khai hợp tác đào tạo, trao đổi học thuật, trao đổi giảng viên và người học với các đối tác trong và ngoài nước.'),
('8.2', '8.2.3', 3, 'Chính sách và chủ trương phát triển mạng lưới, quan hệ và đối tác trong nước được triển khai thực hiện.'),
('8.2', '8.2.4', 4, 'Chính sách và chủ trương phát triển mạng lưới, quan hệ và đối tác ngoài nước được triển khai thực hiện.'),

-- Tiêu chí 8.3
('8.3', '8.3.1', 1, 'CSGD hằng năm rà soát và đánh giá việc hợp tác với các đối tác, mạng lưới và quan hệ trong nước.'),
('8.3', '8.3.2', 2, 'CSGD hằng năm rà soát và đánh giá việc hợp tác với các đối tác, mạng lưới và quan hệ ngoài nước.'),

-- Tiêu chí 8.4
('8.4', '8.4.1', 1, 'CSGD có sự phát triển về số lượng đối tác, mạng lưới hoặc kết quả hoạt động đối ngoại trong chu kỳ 5 năm.'),
('8.4', '8.4.2', 2, 'CSGD thực hiện các biện pháp cải thiện quan hệ hợp tác nhằm đạt được tầm nhìn, sứ mạng và mục tiêu chiến lược.'),



-- Tiêu chí 9.1
('9.1', '9.1.1', 1, 'CSGD có hệ thống đảm bảo chất lượng bên trong bao gồm trung tâm/bộ phận chuyên trách về đảm bảo chất lượng, trong đó có nhân sự được đào tạo hoặc bồi dưỡng về đảm bảo và kiểm định chất lượng giáo dục.'),
('9.1', '9.1.2', 2, 'CSGD có mạng lưới đảm bảo chất lượng tại các đơn vị trực thuộc; có quy định về chức năng, nhiệm vụ của trung tâm/bộ phận chuyên trách và quy định về phối hợp đảm bảo chất lượng nội bộ.'),
('9.1', '9.1.3', 3, 'CSGD có hệ thống văn bản quy định các hoạt động đảm bảo chất lượng và các hướng dẫn thực hiện để hỗ trợ hiệu quả cho công tác quản lý.'),
('9.1', '9.1.4', 4, 'Cán bộ làm công tác đảm bảo chất lượng có văn bằng, chứng chỉ hoặc giấy chứng nhận tham gia các khóa đào tạo, bồi dưỡng liên quan đến đảm bảo chất lượng.'),

-- Tiêu chí 9.2
('9.2', '9.2.1', 1, 'CSGD có kế hoạch chiến lược đảm bảo chất lượng bao gồm chiến lược, chính sách, sự tham gia của các bên liên quan và các hoạt động thúc đẩy đảm bảo chất lượng.'),
('9.2', '9.2.2', 2, 'CSGD có các chính sách ưu tiên cho các hoạt động đảm bảo chất lượng theo kế hoạch chiến lược.'),
('9.2', '9.2.3', 3, 'CSGD có sự tham gia của các bên liên quan trong triển khai các hoạt động đảm bảo chất lượng nhằm đánh giá mức độ đáp ứng mục tiêu chiến lược.'),

-- Tiêu chí 9.3
('9.3', '9.3.1', 1, 'CSGD có các kế hoạch ngắn hạn và dài hạn về đảm bảo chất lượng gắn với kế hoạch chiến lược đảm bảo chất lượng.'),
('9.3', '9.3.2', 2, 'CSGD phổ biến và triển khai các hoạt động thực hiện chiến lược đảm bảo chất lượng theo kế hoạch, bao gồm các hoạt động tập huấn.'),
('9.3', '9.3.3', 3, 'CSGD triển khai và quán triệt thực hiện các hoạt động đảm bảo chất lượng theo kế hoạch hằng năm.'),

-- Tiêu chí 9.4
('9.4', '9.4.1', 1, 'CSGD có hệ thống lưu trữ văn bản về các chính sách, hệ thống, quy trình và thủ tục đảm bảo chất lượng.'),
('9.4', '9.4.2', 2, 'Các văn bản quản lý và cơ sở dữ liệu về đảm bảo chất lượng được lưu trữ có hệ thống, cập nhật thường xuyên và dễ tiếp cận.'),
('9.4', '9.4.3', 3, 'CSGD định kỳ rà soát các chính sách, hệ thống, quy trình và thủ tục đảm bảo chất lượng ít nhất hai năm một lần.'),
('9.4', '9.4.4', 4, 'CSGD phổ biến các chính sách, hệ thống, quy trình và thủ tục đảm bảo chất lượng đến các bên liên quan.'),

-- Tiêu chí 9.5
('9.5', '9.5.1', 1, 'CSGD xây dựng bộ KPIs và các chỉ tiêu phấn đấu chính để đo lường và đánh giá kết quả công tác đảm bảo chất lượng.'),
('9.5', '9.5.2', 2, 'CSGD sử dụng bộ chỉ số KPIs để đo lường và đánh giá kết quả công tác đảm bảo chất lượng.'),

-- Tiêu chí 9.6
('9.6', '9.6.1', 1, 'CSGD thực hiện rà soát và cải tiến quy trình lập kế hoạch các hoạt động nhằm đáp ứng mục tiêu chiến lược và đảm bảo chất lượng ít nhất một lần trong chu kỳ đánh giá 5 năm.'),
('9.6', '9.6.2', 2, 'CSGD thực hiện rà soát và cải tiến các KPIs và chỉ tiêu phấn đấu chính nhằm đáp ứng mục tiêu chiến lược và đảm bảo chất lượng ít nhất một lần trong chu kỳ đánh giá 5 năm.'),



-- Tiêu chí 10.1
('10.1', '10.1.1', 1, 'CSGD có kế hoạch đảm bảo chất lượng, trong đó xác định rõ lộ trình và kế hoạch tự đánh giá và chuẩn bị cho đánh giá ngoài CSGD và các chương trình đào tạo.'),
('10.1', '10.1.2', 2, 'CSGD có các hướng dẫn thực hiện tự đánh giá và chuẩn bị cho đánh giá ngoài, được phổ biến đến các bên liên quan.'),
('10.1', '10.1.3', 3, 'CSGD phân công trách nhiệm cụ thể cho các bộ phận và cá nhân liên quan để thực hiện tự đánh giá và chuẩn bị đánh giá ngoài.'),
('10.1', '10.1.4', 4, 'CSGD thực hiện đầy đủ các bước chuẩn bị cho tự đánh giá và đánh giá ngoài theo kế hoạch.'),

-- Tiêu chí 10.2
('10.2', '10.2.1', 1, 'CSGD thực hiện tự đánh giá theo quy định và có kế hoạch hoặc đã được đánh giá ngoài ít nhất một lần trong chu kỳ đánh giá.'),
('10.2', '10.2.2', 2, 'CSGD có ít nhất ba cán bộ được đào tạo hoặc chứng nhận kiểm định viên kiểm định chất lượng giáo dục, trong đó có ít nhất một cán bộ có thẻ kiểm định viên; các thành viên hội đồng tự đánh giá đã được tập huấn về đảm bảo và kiểm định chất lượng giáo dục.'),

-- Tiêu chí 10.3
('10.3', '10.3.1', 1, 'CSGD xác định và phân tích các điểm mạnh và tồn tại của các lĩnh vực hoạt động thông qua quá trình tự đánh giá.'),
('10.3', '10.3.2', 2, 'CSGD xây dựng kế hoạch hành động khả thi nhằm khắc phục các tồn tại được phát hiện qua tự đánh giá.'),
('10.3', '10.3.3', 3, 'CSGD có báo cáo kết quả cải tiến chất lượng sau khi triển khai các kế hoạch hành động khắc phục tồn tại sau tự đánh giá.'),
('10.3', '10.3.4', 4, 'CSGD xác định và phân tích các điểm mạnh và tồn tại của các lĩnh vực hoạt động thông qua quá trình đánh giá ngoài (nếu đã được đánh giá ngoài).'),
('10.3', '10.3.5', 5, 'CSGD xây dựng kế hoạch hành động khả thi để thực hiện các khuyến nghị cải tiến chất lượng từ kết quả đánh giá ngoài (nếu có).'),
('10.3', '10.3.6', 6, 'CSGD có báo cáo kết quả cải tiến chất lượng sau khi triển khai các kế hoạch hành động theo khuyến nghị của đoàn đánh giá ngoài (nếu có).'),

-- Tiêu chí 10.4
('10.4', '10.4.1', 1, 'CSGD thực hiện rà soát và đánh giá quy trình tự đánh giá ít nhất một lần trong chu kỳ đánh giá 5 năm.'),
('10.4', '10.4.2', 2, 'Quy trình tự đánh giá CSGD hoặc chương trình đào tạo được cải tiến dựa trên kết quả rà soát.'),
('10.4', '10.4.3', 3, 'CSGD thực hiện rà soát và đánh giá quy trình chuẩn bị cho đánh giá ngoài ít nhất một lần trong chu kỳ đánh giá 5 năm.'),
('10.4', '10.4.4', 4, 'Quy trình chuẩn bị cho đánh giá ngoài được cải tiến.'),
('10.4', '10.4.5', 5, 'CSGD tổ chức họp rút kinh nghiệm và chia sẻ các thực hành tốt trong công tác đảm bảo và kiểm định chất lượng giáo dục giữa các đơn vị.'),



-- Tiêu chí 11.1
('11.1', '11.1.1', 1, 'CSGD có kế hoạch xây dựng hệ thống quản lý thông tin đảm bảo chất lượng bên trong nhằm hỗ trợ hoạt động đào tạo, nghiên cứu khoa học và phục vụ cộng đồng.'),
('11.1', '11.1.2', 2, 'CSGD có văn bản phân công trách nhiệm cho bộ phận đầu mối và các bộ phận phối hợp trong việc xây dựng hệ thống quản lý thông tin đảm bảo chất lượng bên trong.'),
('11.1', '11.1.3', 3, 'CSGD có phương án ứng dụng công nghệ thông tin trong xây dựng hệ thống quản lý thông tin đảm bảo chất lượng bên trong.'),

-- Tiêu chí 11.2
('11.2', '11.2.1', 1, 'CSGD xây dựng hệ thống quản lý thông tin đảm bảo chất lượng bên trong trên nền tảng công nghệ thông tin để hỗ trợ công tác ra quyết định.'),
('11.2', '11.2.2', 2, 'Cơ sở dữ liệu của hệ thống thông tin đảm bảo chất lượng bên trong được phân tích chính xác, đầy đủ theo từng lĩnh vực hoạt động nhằm nâng cao chất lượng.'),
('11.2', '11.2.3', 3, 'Cơ sở dữ liệu của hệ thống thông tin đảm bảo chất lượng bên trong được lưu trữ có hệ thống và sẵn sàng trích xuất khi cần.'),
('11.2', '11.2.4', 4, 'CSGD có các biện pháp đảm bảo an toàn và bảo mật cho hệ thống thông tin đảm bảo chất lượng bên trong.'),
('11.2', '11.2.5', 5, 'Các chính sách và thủ tục về an toàn, bảo mật hệ thống thông tin đảm bảo chất lượng bên trong được phổ biến đến cán bộ, giảng viên, nhân viên và các bên liên quan.'),

-- Tiêu chí 11.3
('11.3', '11.3.1', 1, 'CSGD định kỳ hằng năm rà soát, bổ sung và điều chỉnh hệ thống quản lý thông tin đảm bảo chất lượng bên trong.'),
('11.3', '11.3.2', 2, 'CSGD định kỳ hằng năm rà soát, bổ sung và điều chỉnh số lượng, chất lượng, tính thống nhất, an toàn và bảo mật của dữ liệu và thông tin.'),
('11.3', '11.3.3', 3, 'Trong quá trình rà soát và điều chỉnh hệ thống quản lý thông tin đảm bảo chất lượng, CSGD có lấy ý kiến và sử dụng phản hồi của các bên liên quan.'),

-- Tiêu chí 11.4
('11.4', '11.4.1', 1, 'Hệ thống quản lý thông tin đảm bảo chất lượng bên trong của CSGD được cải tiến.'),
('11.4', '11.4.2', 2, 'Các chính sách, quy trình và kế hoạch quản lý thông tin đảm bảo chất lượng bên trong của CSGD được cải tiến và đánh giá là có hiệu quả.'),
('11.4', '11.4.3', 3, 'Thông tin đảm bảo chất lượng bên trong, bao gồm kết quả phân tích đánh giá, được CSGD sử dụng để hỗ trợ đào tạo, nghiên cứu khoa học và phục vụ cộng đồng.'),



-- Tiêu chí 12.1
('12.1', '12.1.1', 1, 'Kế hoạch nâng cao chất lượng có các chính sách, hệ thống, quy trình, thủ tục và nguồn lực để thực hiện tốt nhất hoạt động đào tạo, nghiên cứu khoa học và phục vụ cộng đồng.'),
('12.1', '12.1.2', 2, 'Kế hoạch nâng cao chất lượng có tính liên tục với các mốc thời gian và chỉ tiêu cụ thể để đảm bảo tốt nhất hoạt động đào tạo, nghiên cứu khoa học và phục vụ cộng đồng.'),

-- Tiêu chí 12.2
('12.2', '12.2.1', 1, 'CSGD có tiêu chí lựa chọn đối tác để thực hiện so chuẩn, đối sánh.'),
('12.2', '12.2.2', 2, 'CSGD có tiêu chí xác định nội dung so chuẩn, đối sánh chất lượng.'),
('12.2', '12.2.3', 3, 'CSGD có các hướng dẫn sử dụng tiêu chí lựa chọn đối tác và đối sánh chất lượng nhằm nâng cao chất lượng.'),

-- Tiêu chí 12.3
('12.3', '12.3.1', 1, 'CSGD thực hiện việc so chuẩn và đối sánh chất lượng.'),
('12.3', '12.3.2', 2, 'CSGD sử dụng kết quả so chuẩn và đối sánh chất lượng để tăng cường các hoạt động đảm bảo chất lượng.'),
('12.3', '12.3.3', 3, 'CSGD sử dụng kết quả so chuẩn và đối sánh để khuyến khích đổi mới và sáng tạo.'),

-- Tiêu chí 12.4
('12.4', '12.4.1', 1, 'CSGD thực hiện rà soát quy trình lựa chọn và sử dụng các thông tin so chuẩn, đối sánh chất lượng ít nhất hai lần trong năm năm của chu kỳ đánh giá.'),
('12.4', '12.4.2', 2, 'CSGD có tham chiếu các tiêu chí đối sánh của các CSGD khác khi lựa chọn và xác định thang đo chuẩn.'),

-- Tiêu chí 12.5
('12.5', '12.5.1', 1, 'Quy trình lựa chọn và sử dụng các thông tin so chuẩn, đối sánh được cải tiến nhằm liên tục đạt được các kết quả tốt nhất trong hoạt động đào tạo, nghiên cứu khoa học và phục vụ cộng đồng.'),



-- Tiêu chí 13.1
('13.1', '13.1.1', 1, 'Đề án hoặc văn bản quy định về tuyển sinh thể hiện rõ ràng chính sách tuyển sinh.'),
('13.1', '13.1.2', 2, 'Kế hoạch tuyển sinh có phân công trách nhiệm và xác định thời gian thực hiện.'),
('13.1', '13.1.3', 3, 'CSGD có kế hoạch truyền thông về tuyển sinh.'),

-- Tiêu chí 13.2
('13.2', '13.2.1', 1, 'Các tiêu chí và chỉ tiêu tuyển sinh rõ ràng, theo quy định cho từng chương trình đào tạo.'),
('13.2', '13.2.2', 2, 'Các hình thức thi tuyển hoặc xét tuyển phù hợp và theo quy định.'),

-- Tiêu chí 13.3
('13.3', '13.3.1', 1, 'Có đơn vị hoặc cá nhân được phân công giám sát công tác tuyển sinh và nhập học.'),
('13.3', '13.3.2', 2, 'Có quy trình hoặc quy định giám sát công tác tuyển sinh và nhập học.'),

-- Tiêu chí 13.4
('13.4', '13.4.1', 1, 'CSGD thực hiện các biện pháp giám sát công tác tuyển sinh và nhập học.'),
('13.4', '13.4.2', 2, 'CSGD đánh giá và phân tích kết quả giám sát công tác tuyển sinh và nhập học hằng năm.'),

-- Tiêu chí 13.5
('13.5', '13.5.1', 1, 'CSGD sử dụng kết quả đánh giá công tác tuyển sinh và nhập học làm căn cứ điều chỉnh chiến lược, chính sách và kế hoạch tuyển sinh, nhập học.'),
('13.5', '13.5.2', 2, 'Công tác tuyển sinh và nhập học được cải tiến, cập nhật ít nhất hai lần trong một chu kỳ đánh giá.'),



-- Tiêu chí 14.1
('14.1', '14.1.1', 1, 'CSGD có quy định, hướng dẫn và phân công trách nhiệm cụ thể cho các đơn vị, cá nhân liên quan trong quá trình xây dựng, giám sát, rà soát, thẩm định, phê duyệt và ban hành chương trình dạy học.'),
('14.1', '14.1.2', 2, 'CSGD có quy định, hướng dẫn và phân công trách nhiệm cụ thể cho các đơn vị, cá nhân liên quan trong quá trình xây dựng, giám sát, rà soát, thẩm định, phê duyệt và ban hành đề cương môn học hoặc học phần.'),
('14.1', '14.1.3', 3, 'CSGD có kế hoạch và phương pháp lấy ý kiến đóng góp, phản hồi của các bên liên quan khi xây dựng, phát triển, rà soát và thẩm định chương trình dạy học, đề cương môn học hoặc học phần.'),

-- Tiêu chí 14.2
('14.2', '14.2.1', 1, 'CSGD có quy định, hướng dẫn và phân công trách nhiệm cụ thể cho các đơn vị, cá nhân liên quan trong quá trình xây dựng, rà soát và điều chỉnh chuẩn đầu ra cho chương trình đào tạo, môn học hoặc học phần.'),
('14.2', '14.2.2', 2, 'CSGD có kế hoạch tham khảo ý kiến của các bên liên quan về việc xây dựng, rà soát và điều chỉnh chuẩn đầu ra cho chương trình đào tạo, môn học hoặc học phần.'),

-- Tiêu chí 14.3
('14.3', '14.3.1', 1, 'CSGD ban hành và công bố chính thức đề cương môn học hoặc học phần và kế hoạch giảng dạy dựa trên chuẩn đầu ra.'),
('14.3', '14.3.2', 2, 'CSGD giới thiệu và phổ biến đề cương môn học hoặc học phần và kế hoạch giảng dạy đến người học bằng nhiều hình thức khác nhau.'),
('14.3', '14.3.3', 3, 'Các hoạt động dạy học theo đề cương môn học hoặc học phần được triển khai đúng kế hoạch và hướng tới đạt được chuẩn đầu ra.'),

-- Tiêu chí 14.4
('14.4', '14.4.1', 1, 'CSGD thực hiện rà soát quy trình thiết kế và đánh giá chương trình dạy học ít nhất một lần trong năm năm của chu kỳ đánh giá.'),
('14.4', '14.4.2', 2, 'CSGD định kỳ rà soát chương trình dạy học ít nhất hai năm một lần, trong đó có tham khảo các chương trình tiên tiến trong nước hoặc quốc tế và lấy ý kiến phản hồi của các bên liên quan.'),

-- Tiêu chí 14.5
('14.5', '14.5.1', 1, 'CSGD ban hành quy trình thiết kế, phát triển và đánh giá chương trình dạy học.'),
('14.5', '14.5.2', 2, 'Chương trình dạy học được cải tiến và ban hành đáp ứng nhu cầu của các bên liên quan.'),



-- Tiêu chí 15.1
('15.1', '15.1.1', 1, 'CSGD có tuyên bố chính thức về triết lý giáo dục; nội dung triết lý phù hợp với mục tiêu, sứ mạng của CSGD và với xu thế phát triển chung.'),
('15.1', '15.1.2', 2, 'CSGD có quy định và hướng dẫn về việc xác định, lựa chọn các hoạt động dạy và học phù hợp với triết lý giáo dục.'),
('15.1', '15.1.3', 3, 'CSGD có quy định và hướng dẫn về việc xác định, lựa chọn các hoạt động dạy và học nhằm đạt được chuẩn đầu ra.'),

-- Tiêu chí 15.2
('15.2', '15.2.1', 1, 'CSGD thực hiện chiến lược và chính sách về thu hút, tuyển dụng, bổ nhiệm và phát triển đội ngũ giảng viên.'),
('15.2', '15.2.2', 2, 'CSGD thực hiện phân công nhiệm vụ cho giảng viên dựa trên trình độ chuyên môn, năng lực, thành tích chuyên môn và kinh nghiệm.'),

-- Tiêu chí 15.3
('15.3', '15.3.1', 1, 'CSGD tạo dựng môi trường học tập đa dạng, thuận lợi cho việc đạt chuẩn đầu ra, học tập, nghiên cứu và thúc đẩy người học tìm tòi, khám phá kiến thức.'),
('15.3', '15.3.2', 2, 'CSGD triển khai các hoạt động học tập đa dạng như dự án đào tạo, đào tạo thực hành, bài tập lớn, thực tập tại doanh nghiệp và các hoạt động tương đương.'),
('15.3', '15.3.3', 3, 'CSGD ứng dụng các phương pháp và công nghệ giảng dạy hiện đại, phù hợp để đạt chuẩn đầu ra của các môn học hoặc học phần.'),

-- Tiêu chí 15.4
('15.4', '15.4.1', 1, 'CSGD thực hiện giám sát hoạt động dạy và học hằng năm.'),
('15.4', '15.4.2', 2, 'CSGD thực hiện việc đánh giá giảng viên.'),
('15.4', '15.4.3', 3, 'CSGD thực hiện đánh giá chất lượng hằng năm từ người học của các ngành đào tạo trong quá trình học tập và sau khi ra trường.'),
('15.4', '15.4.4', 4, 'CSGD triển khai cải tiến chất lượng phương pháp giảng dạy, kiểm tra và đánh giá người học dựa trên kết quả khảo sát môn học.'),

-- Tiêu chí 15.5
('15.5', '15.5.1', 1, 'CSGD điều chỉnh triết lý giáo dục ít nhất một lần trong chu kỳ đánh giá; nội dung điều chỉnh phù hợp với chuẩn đầu ra và tiếp cận các xu hướng mới.'),
('15.5', '15.5.2', 2, 'CSGD điều chỉnh các hoạt động dạy và học ít nhất hai năm một lần; nội dung điều chỉnh phù hợp với triết lý giáo dục nhằm đạt chuẩn đầu ra.'),
('15.5', '15.5.3', 3, 'CSGD lấy ý kiến các bên liên quan về mức độ hài lòng đối với triết lý giáo dục và các hoạt động dạy và học.'),



-- Tiêu chí 16.1
('16.1', '16.1.1', 1, 'CSGD có quy trình thiết lập hệ thống lập kế hoạch và lựa chọn các loại hình đánh giá người học phù hợp trong quá trình học tập.'),
('16.1', '16.1.2', 2, 'CSGD có quy định, hướng dẫn và kế hoạch đánh giá người học; có phân công trách nhiệm cụ thể.'),
('16.1', '16.1.3', 3, 'CSGD có các loại hình, tiêu chí và nội dung đánh giá phù hợp trong quá trình học tập đối với từng môn học hoặc học phần trong chương trình dạy học.'),

-- Tiêu chí 16.2
('16.2', '16.2.1', 1, 'CSGD thực hiện quy trình rõ ràng về việc đánh giá kết quả người học nhằm đạt được chuẩn đầu ra và được công bố công khai đến các bên liên quan.'),
('16.2', '16.2.2', 2, 'CSGD thực hiện nhiều phương pháp kiểm tra và đánh giá phù hợp để đạt được chuẩn đầu ra.'),
('16.2', '16.2.3', 3, 'Các phương pháp kiểm tra và đánh giá người học đo lường được mức độ đạt chuẩn đầu ra.'),

-- Tiêu chí 16.3
('16.3', '16.3.1', 1, 'CSGD thực hiện rà soát và đánh giá các phương pháp kiểm tra, đánh giá người học định kỳ ít nhất một lần mỗi năm.'),
('16.3', '16.3.2', 2, 'CSGD thực hiện nghiên cứu và phân tích kết quả kiểm tra, đánh giá người học và tác động của các hình thức đánh giá đối với chất lượng đào tạo bằng các công cụ hiện đại và hiệu quả.'),
('16.3', '16.3.3', 3, 'CSGD công bố kết quả đánh giá kịp thời và xử lý hợp lý các trường hợp khiếu nại hoặc phúc tra.'),
('16.3', '16.3.4', 4, 'CSGD thực hiện khảo sát hoặc lấy ý kiến của người học và cựu người học về hoạt động kiểm tra, đánh giá.'),

-- Tiêu chí 16.4
('16.4', '16.4.1', 1, 'CSGD thực hiện thay đổi và cải tiến các loại hình hoặc phương pháp đánh giá người học.'),
('16.4', '16.4.2', 2, 'CSGD định kỳ đánh giá độ tin cậy và độ chính xác của các loại hình hoặc phương pháp kiểm tra, đánh giá người học.'),
('16.4', '16.4.3', 3, 'Quy trình xây dựng và đánh giá độ tin cậy, độ chính xác của các phương pháp kiểm tra, đánh giá được thực hiện khoa học, được kiểm chứng trước khi áp dụng và được thông báo công khai cho người học trước mỗi khóa học, kỳ học hoặc học phần.'),
('16.4', '16.4.4', 4, 'Không có tình trạng khiếu nại hoặc phàn nàn của người học về sự thiếu công bằng hoặc minh bạch trong việc sử dụng các phương pháp đánh giá kết quả học tập.'),



-- Tiêu chí 17.1
('17.1', '17.1.1', 1, 'CSGD có quy chế, quy định hoặc văn bản về việc triển khai các hoạt động phục vụ và hỗ trợ người học.'),
('17.1', '17.1.2', 2, 'CSGD có kế hoạch thực hiện và phân công trách nhiệm cụ thể cho các đơn vị hoặc cá nhân trong việc triển khai các hoạt động phục vụ và hỗ trợ người học.'),
('17.1', '17.1.3', 3, 'CSGD có hệ thống giám sát người học như phần mềm quản lý, cơ sở dữ liệu đánh giá tiến trình học tập, kết quả học tập và nghiên cứu, hoạt động thanh tra đào tạo.'),
('17.1', '17.1.4', 4, 'CSGD có bộ tiêu chí đánh giá năng lực của đội ngũ cán bộ, nhân viên hỗ trợ; thực hiện đo lường và đánh giá mức độ hài lòng đối với các dịch vụ hỗ trợ.'),

-- Tiêu chí 17.2
('17.2', '17.2.1', 1, 'CSGD có đơn vị chịu trách nhiệm tư vấn và hỗ trợ học tập cho người học; có đội ngũ cán bộ, nhân viên đủ trình độ thực hiện tư vấn và hỗ trợ.'),
('17.2', '17.2.2', 2, 'CSGD triển khai các hoạt động phục vụ và hỗ trợ người học.'),
('17.2', '17.2.3', 3, 'CSGD triển khai các hoạt động giám sát tiến trình và hiệu quả học tập của người học.'),
('17.2', '17.2.4', 4, 'CSGD thực hiện khảo sát người học về hiệu quả của các hoạt động phục vụ, hỗ trợ và giám sát.'),

-- Tiêu chí 17.3
('17.3', '17.3.1', 1, 'CSGD thực hiện rà soát và đánh giá định kỳ chất lượng các hoạt động phục vụ và hỗ trợ người học; có kế hoạch cải tiến sau rà soát.'),
('17.3', '17.3.2', 2, 'CSGD thực hiện rà soát và đánh giá định kỳ hiệu quả của hệ thống giám sát người học; có kế hoạch cải tiến sau rà soát.'),

-- Tiêu chí 17.4
('17.4', '17.4.1', 1, 'CSGD có các chỉ số thể hiện sự cải thiện về chất lượng các hoạt động phục vụ và hỗ trợ người học.'),
('17.4', '17.4.2', 2, 'CSGD có các chỉ số thể hiện sự cải thiện về phần mềm quản lý người học, cơ sở dữ liệu kết quả đánh giá và hệ thống cố vấn học tập.'),
('17.4', '17.4.3', 3, 'Ít nhất 75 phần trăm người học và cựu người học được khảo sát hài lòng về các hoạt động phục vụ, hỗ trợ và hệ thống giám sát người học.'),



-- Tiêu chí 18.1
('18.1', '18.1.1', 1, 'Có cơ cấu tổ chức quản lý việc thực hiện giám sát, rà soát các hoạt động nghiên cứu.'),
('18.1', '18.1.2', 2, 'Có các chính sách, cơ chế chỉ đạo thực hiện giám sát và rà soát các hoạt động nghiên cứu.'),
('18.1', '18.1.3', 3, 'Có các quy định hoặc hướng dẫn công tác quản lý; quy trình xây dựng và đề xuất các hoạt động nghiên cứu; quy định về khối lượng NCKH đối với cán bộ, giảng viên.'),
('18.1', '18.1.4', 4, 'Có kế hoạch và dự toán phân bổ kinh phí cho hoạt động nghiên cứu khoa học hằng năm theo quy định.'),
('18.1', '18.1.5', 5, 'Có các tiêu chí đánh giá số lượng và chất lượng nghiên cứu khoa học; có bộ phận theo dõi, giám sát và đánh giá chất lượng các hoạt động nghiên cứu.'),

-- Tiêu chí 18.2
('18.2', '18.2.1', 1, 'CSGD triển khai chiến lược phát triển nguồn thu từ hoạt động nghiên cứu khoa học và chuyển giao công nghệ, chuyển giao tri thức, thương mại hóa sản phẩm nghiên cứu.'),
('18.2', '18.2.2', 2, 'CSGD thiết lập các nhóm nghiên cứu và có chính sách thu hút cán bộ, giảng viên và người học tham gia các hoạt động nghiên cứu.'),
('18.2', '18.2.3', 3, 'CSGD triển khai các hoạt động hợp tác nghiên cứu khoa học hoặc chuyển giao công nghệ với doanh nghiệp, tổ chức xã hội và các cơ sở nghiên cứu trong và ngoài nước.'),
('18.2', '18.2.4', 4, 'CSGD triển khai các hoạt động khoa học và công nghệ theo kế hoạch đã đề ra.'),

-- Tiêu chí 18.3
('18.3', '18.3.1', 1, 'CSGD xây dựng các KPIs cụ thể về số lượng và chất lượng nghiên cứu khoa học.'),
('18.3', '18.3.2', 2, 'CSGD sử dụng các tiêu chí đánh giá chất lượng và số lượng nghiên cứu khoa học để đánh giá mức độ đạt được các KPIs; đánh giá tác động của nghiên cứu và mức độ đóng góp cho xã hội.'),
('18.3', '18.3.3', 3, 'CSGD định kỳ rà soát và đánh giá việc thực hiện các KPIs làm căn cứ đề xuất và điều chỉnh các kế hoạch khoa học và công nghệ.'),

-- Tiêu chí 18.4
('18.4', '18.4.1', 1, 'CSGD lấy ý kiến khảo sát của các bên liên quan về công tác quản lý nghiên cứu.'),
('18.4', '18.4.2', 2, 'CSGD cải tiến công tác quản lý nghiên cứu và được các bên liên quan đánh giá tốt.'),



-- Tiêu chí 19.1
('19.1', '19.1.1', 1, 'CSGD có đơn vị, bộ phận hoặc nhân sự quản lý và hỗ trợ bảo hộ các phát minh, sáng chế, bản quyền và kết quả nghiên cứu.'),
('19.1', '19.1.2', 2, 'CSGD có quy định rõ ràng về việc bảo vệ quyền sở hữu trí tuệ đối với các sáng chế, bản quyền và kết quả nghiên cứu; có quy định về định giá các đối tượng sở hữu trí tuệ phù hợp với yêu cầu quốc gia và quốc tế.'),
('19.1', '19.1.3', 3, 'CSGD có chính sách hỗ trợ trong giai đoạn chuẩn bị và hỗ trợ khai thác, thương mại hóa các đề tài nghiên cứu.'),
('19.1', '19.1.4', 4, 'CSGD có quy định về việc khai thác tài sản trí tuệ như thử nghiệm, sản xuất thử, thương mại hóa và trích dẫn.'),
('19.1', '19.1.5', 5, 'CSGD có quy định về quy trình công bố, theo dõi và lưu trữ kết quả nghiên cứu.'),

-- Tiêu chí 19.2
('19.2', '19.2.1', 1, 'Các tài sản trí tuệ của CSGD được đăng ký bảo hộ theo đúng quy định của pháp luật.'),
('19.2', '19.2.2', 2, 'CSGD phổ biến, hướng dẫn và hỗ trợ cán bộ khoa học, giảng viên về các quy định liên quan đến quyền sở hữu trí tuệ.'),
('19.2', '19.2.3', 3, 'CSGD thực hiện xây dựng cơ sở dữ liệu; rà soát và phát hiện các hành vi vi phạm tài sản trí tuệ.'),

-- Tiêu chí 19.3
('19.3', '19.3.1', 1, 'CSGD triển khai rà soát công tác quản lý tài sản trí tuệ ít nhất hai lần trong một chu kỳ đánh giá.'),
('19.3', '19.3.2', 2, 'CSGD thực hiện tổng kết và đánh giá công tác quản lý tài sản trí tuệ.'),

-- Tiêu chí 19.4
('19.4', '19.4.1', 1, 'CSGD có kế hoạch và triển khai thực hiện cải tiến công tác quản lý tài sản trí tuệ nhằm bảo hộ hiệu quả cho CSGD, cán bộ nghiên cứu và lợi ích cộng đồng.'),
('19.4', '19.4.2', 2, 'Ít nhất 75 phần trăm các bên liên quan được khảo sát hài lòng về công tác quản lý tài sản trí tuệ của CSGD.'),



-- Tiêu chí 20.1
('20.1', '20.1.1', 1, 'CSGD có quy định về việc thiết lập các mối quan hệ hợp tác trong nghiên cứu nhằm đáp ứng các mục tiêu nghiên cứu.'),
('20.1', '20.1.2', 2, 'CSGD có chiến lược phát triển hợp tác và đối tác; các kế hoạch dài hạn và ngắn hạn được xây dựng dựa trên chiến lược phát triển và phù hợp với sứ mạng, tầm nhìn của CSGD.'),
('20.1', '20.1.3', 3, 'CSGD có các quy định, hướng dẫn và phổ biến thực hiện; có phân công trách nhiệm cụ thể cho các bộ phận, cá nhân; có sự kết nối giữa các bộ phận đầu mối với các khoa, phòng trong quản lý công tác phát triển hợp tác và đối tác.'),
('20.1', '20.1.4', 4, 'CSGD xây dựng các KPIs cho các chiến lược và kế hoạch tăng cường hợp tác với các đối tác trong hoạt động nghiên cứu khoa học.'),

-- Tiêu chí 20.2
('20.2', '20.2.1', 1, 'CSGD triển khai các hoạt động theo chiến lược phát triển, kế hoạch hợp tác và phát triển đối tác nhằm đạt được các KPIs đã xác định.'),
('20.2', '20.2.2', 2, 'CSGD lựa chọn các đối tác và triển khai hợp tác nghiên cứu khoa học phù hợp với tầm nhìn và sứ mạng của CSGD.'),
('20.2', '20.2.3', 3, 'CSGD thúc đẩy các mối quan hệ hợp tác và triển khai các hình thức hợp tác nghiên cứu đa dạng, phù hợp.'),
('20.2', '20.2.4', 4, 'CSGD có đầu tư phù hợp cho việc xây dựng và phát triển các mối quan hệ hợp tác và các đối tác.'),
('20.2', '20.2.5', 5, 'CSGD thúc đẩy các mối quan hệ hợp tác và triển khai các hoạt động hợp tác nghiên cứu mang lại hiệu quả trong nghiên cứu khoa học.'),
('20.2', '20.2.6', 6, 'CSGD tổ chức hoặc đồng tổ chức các hội nghị, hội thảo khoa học với các đối tác trong và ngoài nước.'),

-- Tiêu chí 20.3
('20.3', '20.3.1', 1, 'CSGD có bộ phận hoặc nhân sự chuyên trách và quy trình thực hiện rà soát tính hiệu quả của các hoạt động hợp tác nghiên cứu khoa học.'),
('20.3', '20.3.2', 2, 'CSGD tổ chức rà soát và đánh giá tính hiệu quả của các mối quan hệ hợp tác, các đối tác theo từng giai đoạn hoặc giữa giai đoạn làm căn cứ điều chỉnh hoạt động và xây dựng các đối tác chiến lược.'),
('20.3', '20.3.3', 3, 'CSGD thực hiện rà soát và đánh giá tính hiệu quả cũng như các nguồn lực mang lại từ các hoạt động hợp tác trong đào tạo và nghiên cứu khoa học ít nhất một lần trong chu kỳ đánh giá.'),

-- Tiêu chí 20.4
('20.4', '20.4.1', 1, 'CSGD thực hiện cải thiện các mối quan hệ hợp tác trong nghiên cứu khoa học; lựa chọn lại các đối tác sau rà soát nhằm nâng cao hiệu quả các hoạt động hợp tác và phát triển đối tác.'),
('20.4', '20.4.2', 2, 'CSGD gia tăng được số lượng và chất lượng các mối quan hệ hợp tác và đối tác như các nhà khoa học, nhà tuyển dụng và các đối tác có uy tín, xứng tầm.'),
('20.4', '20.4.3', 3, 'Kết quả của các hoạt động phát triển hợp tác và đối tác của CSGD đáp ứng được các mục tiêu nghiên cứu đã đề ra.'),
('20.4', '20.4.4', 4, 'Các hoạt động hợp tác và đối tác của CSGD góp phần gia tăng các nguồn lực cho CSGD về nhân lực và tài lực.'),



-- Tiêu chí 21.1
('21.1', '21.1.1', 1, 'CSGD có các chính sách và kế hoạch kết nối, cung cấp các dịch vụ phục vụ cộng đồng nhằm thực hiện tầm nhìn và sứ mạng của CSGD.'),
('21.1', '21.1.2', 2, 'CSGD có quy định quản lý và hướng dẫn về hoạt động kết nối và cung cấp các dịch vụ phục vụ cộng đồng, tuân thủ các quy định của pháp luật; quy định rõ cơ chế quản lý, kiểm tra và giám sát các hoạt động này.'),
('21.1', '21.1.3', 3, 'CSGD có quy định về nhiệm vụ và nhân sự chịu trách nhiệm xây dựng kế hoạch và chính sách kết nối, cung cấp các dịch vụ phục vụ cộng đồng.'),

-- Tiêu chí 21.2
('21.2', '21.2.1', 1, 'CSGD triển khai các chính sách và kế hoạch kết nối, cung cấp các dịch vụ phục vụ cộng đồng nhằm thực hiện tầm nhìn và sứ mạng của CSGD và mang lại các kết quả cụ thể như hoạt động tình nguyện của giảng viên và người học, chuyển giao khoa học và công nghệ.'),
('21.2', '21.2.2', 2, 'CSGD thực hiện đúng và đầy đủ các quy định quản lý và hướng dẫn về hoạt động kết nối, cung cấp các dịch vụ phục vụ cộng đồng theo quy định của pháp luật.'),

-- Tiêu chí 21.3
('21.3', '21.3.1', 1, 'CSGD xây dựng hệ thống đo lường kết quả kết nối và phục vụ cộng đồng thông qua các chỉ số và chỉ báo cụ thể.'),
('21.3', '21.3.2', 2, 'CSGD có cơ sở dữ liệu về các hoạt động phục vụ cộng đồng bao gồm kế hoạch, các bên tham gia, các đóng góp cho xã hội và các nguồn lực thu nhận được từ hoạt động dịch vụ và chuyển giao.'),
('21.3', '21.3.3', 3, 'CSGD thực hiện giám sát việc triển khai các hoạt động kết nối và cung cấp các dịch vụ phục vụ cộng đồng.'),
('21.3', '21.3.4', 4, 'CSGD triển khai đánh giá hiệu quả các hoạt động kết nối và phục vụ cộng đồng nhằm tăng cường trách nhiệm đối với xã hội.'),

-- Tiêu chí 21.4
('21.4', '21.4.1', 1, 'CSGD có kế hoạch cung cấp các dịch vụ phục vụ và kết nối cộng đồng.'),
('21.4', '21.4.2', 2, 'CSGD thực hiện các hoạt động cải tiến việc cung cấp các dịch vụ phục vụ và kết nối cộng đồng theo kế hoạch, đáp ứng nhu cầu của các bên liên quan.'),
('21.4', '21.4.3', 3, 'Ít nhất 75 phần trăm các bên liên quan được khảo sát hài lòng về kết quả thực hiện các hoạt động dịch vụ phục vụ và kết nối cộng đồng.'),



-- Tiêu chí 22.1
('22.1', '22.1.1', 1, 'CSGD có kế hoạch đào tạo trong đó xác định và phân tích, dự đoán được tỷ lệ tốt nghiệp đúng hạn và tỷ lệ thôi học của tất cả các chương trình đào tạo.'),
('22.1', '22.1.2', 2, 'CSGD có hệ thống theo dõi, giám sát và đánh giá tỷ lệ tốt nghiệp, tỷ lệ thôi học của tất cả các chương trình đào tạo; tỷ lệ học lại và thi lại các môn học hoặc học phần để đề xuất biện pháp cải tiến chất lượng phù hợp.'),
('22.1', '22.1.3', 3, 'CSGD thực hiện đối sánh tỷ lệ tốt nghiệp và tỷ lệ thôi học giữa các khóa học của cùng chương trình đào tạo, giữa các chương trình đào tạo trong CSGD và với các chương trình đào tạo tương ứng trong nước và quốc tế; dự đoán được xu thế biến động của các tỷ lệ này.'),
('22.1', '22.1.4', 4, 'CSGD triển khai các biện pháp cải tiến chất lượng phù hợp nhằm tăng tỷ lệ tốt nghiệp, giảm tỷ lệ thôi học và giảm tỷ lệ học lại, thi lại các môn học hoặc học phần cho tất cả các chương trình đào tạo.'),

-- Tiêu chí 22.2
('22.2', '22.2.1', 1, 'CSGD có kế hoạch đào tạo trong đó xác lập được thời gian tốt nghiệp trung bình của người học đối với tất cả các chương trình đào tạo.'),
('22.2', '22.2.2', 2, 'CSGD có hệ thống theo dõi và giám sát thời gian tốt nghiệp trung bình của người học nhằm đề xuất các biện pháp cải tiến chất lượng phù hợp.'),
('22.2', '22.2.3', 3, 'CSGD thực hiện đối sánh thời gian tốt nghiệp trung bình giữa các khóa học của cùng chương trình đào tạo, giữa các chương trình đào tạo trong CSGD và với các chương trình đào tạo tương ứng trong nước; dự đoán được thời gian tốt nghiệp trung bình của người học.'),
('22.2', '22.2.4', 4, 'CSGD triển khai các biện pháp cải tiến chất lượng phù hợp nhằm nâng cao tỷ lệ tốt nghiệp và rút ngắn thời gian tốt nghiệp của tất cả các chương trình đào tạo.'),

-- Tiêu chí 22.3
('22.3', '22.3.1', 1, 'CSGD có kế hoạch đào tạo trong đó xác định được tỷ lệ người học có việc làm sau khi tốt nghiệp của tất cả các chương trình đào tạo.'),
('22.3', '22.3.2', 2, 'CSGD có hệ thống theo dõi và giám sát tỷ lệ người học có việc làm trong vòng một năm sau khi tốt nghiệp đối với tất cả các chương trình đào tạo.'),
('22.3', '22.3.3', 3, 'Tỷ lệ người học có việc làm trong vòng một năm sau khi tốt nghiệp đạt từ 50 phần trăm trở lên, trong đó ít nhất 20 phần trăm làm việc phù hợp với chuyên ngành đào tạo; tỷ lệ có việc làm trong vòng ba năm sau khi tốt nghiệp đạt từ 80 phần trăm trở lên, trong đó ít nhất 50 phần trăm làm việc đúng chuyên môn.'),
('22.3', '22.3.4', 4, 'CSGD thực hiện đối sánh tỷ lệ có việc làm và mức độ đáp ứng yêu cầu công việc của người học sau khi tốt nghiệp giữa các khóa học của cùng chương trình đào tạo, giữa các chương trình đào tạo trong CSGD và với các chương trình đào tạo tương ứng trong nước; dự đoán được tỷ lệ có việc làm của người học sau tốt nghiệp.'),
('22.3', '22.3.5', 5, 'CSGD triển khai các biện pháp hướng nghiệp và hỗ trợ tìm việc làm cho sinh viên nhằm nâng cao tỷ lệ có việc làm và mức độ đáp ứng yêu cầu công việc sau tốt nghiệp của tất cả các chương trình đào tạo.'),

-- Tiêu chí 22.4
('22.4', '22.4.1', 1, 'CSGD có kế hoạch khảo sát mức độ hài lòng của các bên liên quan về chất lượng của người học sau tốt nghiệp đối với tất cả các chương trình đào tạo.'),
('22.4', '22.4.2', 2, 'CSGD có hệ thống thu thập thông tin phản hồi của các bên liên quan, bao gồm quy trình, phương pháp, công cụ và chỉ số nhằm đánh giá mức độ hài lòng về chất lượng người học sau tốt nghiệp.'),
('22.4', '22.4.3', 3, 'CSGD thực hiện khảo sát và đánh giá mức độ hài lòng của các bên liên quan đối với chất lượng người học sau tốt nghiệp của tất cả các chương trình đào tạo.'),
('22.4', '22.4.4', 4, 'CSGD có cơ chế giám sát và sử dụng thông tin phản hồi của các bên liên quan nhằm cải tiến chất lượng người học sau tốt nghiệp.'),
('22.4', '22.4.5', 5, 'CSGD thực hiện đối sánh mức độ hài lòng của các bên liên quan đối với chất lượng người học sau tốt nghiệp giữa các khóa học trước và sau của tất cả các chương trình đào tạo.'),
('22.4', '22.4.6', 6, 'CSGD triển khai các biện pháp cải tiến nhằm nâng cao mức độ hài lòng của các bên liên quan về chất lượng người học sau tốt nghiệp của tất cả các chương trình đào tạo.');



-- Tiêu chí 23.1
('23.1', '23.1.1', 1, 'Có quy định cụ thể về các loại hình hoạt động nghiên cứu; số lượng và chất lượng NCKH mà đội ngũ GV và cán bộ nghiên cứu phải thực hiện (ví dụ số lượng công trình NCKH, bài báo, tham dự hội thảo…) theo định mức ứng với mỗi vị trí công việc khác nhau theo quy định hiện hành.'),
('23.1', '23.1.2', 2, 'Có hệ thống theo dõi, giám sát các hoạt động NCKH của đội ngũ GV và cán bộ nghiên cứu; có CSDL được cập nhật về loại hình và khối lượng nghiên cứu đạt được của từng GV và cán bộ nghiên cứu.'),
('23.1', '23.1.3', 3, 'Có hệ thống thu thập thông tin phản hồi của các bên liên quan về chất lượng hoạt động nghiên cứu của đội ngũ GV và cán bộ nghiên cứu.'),
('23.1', '23.1.4', 4, 'Thực hiện việc đối sánh về loại hình, khối lượng và chất lượng nghiên cứu của đội ngũ GV và cán bộ nghiên cứu (đối sánh trong nước, quốc tế, theo lĩnh vực).'),
('23.1', '23.1.5', 5, 'Có kế hoạch cải tiến để tăng số lượng và chất lượng các hoạt động NCKH của đội ngũ GV và cán bộ nghiên cứu.'),

-- Tiêu chí 23.2
('23.2', '23.2.1', 1, 'Có quy định cụ thể về các loại hình hoạt động nghiên cứu; số lượng và chất lượng NCKH mà người học thực hiện.'),
('23.2', '23.2.2', 2, 'Có hệ thống theo dõi, giám sát loại hình, khối lượng và chất lượng nghiên cứu; có CSDL được cập nhật về các loại hình, khối lượng và chất lượng nghiên cứu của người học.'),
('23.2', '23.2.3', 3, 'Có hệ thống thu thập thông tin phản hồi của các bên liên quan về chất lượng hoạt động nghiên cứu của người học.'),
('23.2', '23.2.4', 4, 'Thực hiện việc đối sánh về loại hình, khối lượng và chất lượng nghiên cứu của người học (đối sánh trong nước, quốc tế, theo lĩnh vực).'),
('23.2', '23.2.5', 5, 'Có kế hoạch cải tiến để tăng số lượng và chất lượng các hoạt động NCKH của người học.'),

-- Tiêu chí 23.3
('23.3', '23.3.1', 1, 'Có quy định cụ thể về các loại hình và số lượng các công bố khoa học, bao gồm cả các trích dẫn cho từng năm và theo giai đoạn.'),
('23.3', '23.3.2', 2, 'Có hệ thống theo dõi, giám sát; có CSDL được cập nhật về các loại hình và số lượng các công bố khoa học, bao gồm cả các trích dẫn và chỉ số IF.'),
('23.3', '23.3.3', 3, 'Có hệ thống thu thập thông tin phản hồi của các bên liên quan về các loại hình và số lượng các công bố khoa học, bao gồm các trích dẫn.'),
('23.3', '23.3.4', 4, 'Thực hiện việc đối sánh về các loại hình và số lượng các công bố khoa học, bao gồm các trích dẫn.'),
('23.3', '23.3.5', 5, 'Có kế hoạch cải tiến để nâng cao chất lượng và số lượng các công bố khoa học, bao gồm các trích dẫn.'),

-- Tiêu chí 23.4
('23.4', '23.4.1', 1, 'CSGD có quy định cụ thể về các loại hình và số lượng các tài sản trí tuệ, bao gồm quy định về sở hữu trí tuệ.'),
('23.4', '23.4.2', 2, 'Có hệ thống theo dõi, giám sát loại hình và số lượng các tài sản trí tuệ; có CSDL được cập nhật về tài sản trí tuệ.'),
('23.4', '23.4.3', 3, 'Thực hiện việc đối sánh loại hình và số lượng các tài sản trí tuệ; rà soát, điều chỉnh các chỉ số hằng năm; có kế hoạch cải tiến căn cứ thông tin phản hồi của các bên liên quan.'),
('23.4', '23.4.4', 4, 'Thực hiện việc đối sánh về các loại hình và số lượng các công bố khoa học, bao gồm các trích dẫn.'),
('23.4', '23.4.5', 5, 'Có kế hoạch cải tiến để nâng cao chất lượng và số lượng các tài sản trí tuệ.'),

-- Tiêu chí 23.5
('23.5', '23.5.1', 1, 'CSGD có văn bản quy định cụ thể việc phân bổ ngân quỹ cho từng loại hoạt động nghiên cứu; tổng chi cho hoạt động NCKH và chuyển giao công nghệ đáp ứng quy định hiện hành.'),
('23.5', '23.5.2', 2, 'Có hệ thống thu thập thông tin phản hồi của GV, cán bộ nghiên cứu về mức độ phù hợp, minh bạch của ngân quỹ cho từng loại hoạt động nghiên cứu.'),
('23.5', '23.5.3', 3, 'Có hệ thống giám sát việc phân bổ ngân quỹ cho từng loại hoạt động nghiên cứu (quy định, hướng dẫn, tiêu chí, phương pháp đánh giá…).'),
('23.5', '23.5.4', 4, 'Thực hiện đối sánh, điều chỉnh ngân quỹ cho từng loại hoạt động nghiên cứu hằng năm; có kế hoạch nâng cao mức đầu tư.'),

-- Tiêu chí 23.6
('23.6', '23.6.1', 1, 'CSGD có quy định cụ thể về kết quả nghiên cứu và sáng tạo (bao gồm thương mại hóa, thử nghiệm chuyển giao, thành lập đơn vị khởi nghiệp) trong hoạt động KHCN.'),
('23.6', '23.6.2', 2, 'Có hệ thống thu thập thông tin phản hồi của các bên liên quan về chất lượng kết quả nghiên cứu và sáng tạo.'),
('23.6', '23.6.3', 3, 'Có các đơn vị khởi nghiệp, thử nghiệm chuyển giao và hoạt động nghiên cứu sáng tạo.'),
('23.6', '23.6.4', 4, 'Thực hiện việc đối sánh, rà soát và điều chỉnh hoạt động nghiên cứu và sáng tạo; có kế hoạch cải tiến căn cứ thông tin phản hồi của các bên liên quan.'),



-- Tiêu chí 24.1
('24.1', '24.1.1', 1, 'Có văn bản quy định cụ thể về loại hình và khối lượng tham gia vào hoạt động kết nối và phục vụ cộng đồng, đóng góp cho xã hội.'),
('24.1', '24.1.2', 2, 'Có hệ thống giám sát về loại hình và khối lượng tham gia vào hoạt động kết nối và phục vụ cộng đồng, đóng góp cho xã hội.'),
('24.1', '24.1.3', 3, 'Có thực hiện đối sánh về loại hình và khối lượng tham gia vào hoạt động kết nối và phục vụ cộng đồng, đóng góp cho xã hội; thực hiện rà soát, điều chỉnh loại hình và khối lượng tham gia hằng năm.'),
('24.1', '24.1.4', 4, 'Có hệ thống thu thập thông tin phản hồi của các bên liên quan về loại hình và khối lượng tham gia vào hoạt động kết nối và phục vụ cộng đồng, đóng góp cho xã hội.'),
('24.1', '24.1.5', 5, 'Có kế hoạch cải tiến chất lượng hoạt động kết nối và phục vụ cộng đồng, đóng góp cho xã hội căn cứ thông tin phản hồi của các bên liên quan.'),

-- Tiêu chí 24.2
('24.2', '24.2.1', 1, 'Có kế hoạch và thực hiện đánh giá tác động của hoạt động kết nối và phục vụ cộng đồng.'),
('24.2', '24.2.2', 2, 'Có hệ thống giám sát về tác động xã hội và kết quả của hoạt động kết nối và phục vụ cộng đồng, đóng góp cho xã hội.'),
('24.2', '24.2.3', 3, 'Có thực hiện đối sánh về tác động xã hội và kết quả của hoạt động kết nối và phục vụ cộng đồng, đóng góp cho xã hội.'),
('24.2', '24.2.4', 4, 'Có hệ thống thu thập thông tin phản hồi của các bên liên quan về tác động xã hội và kết quả của hoạt động kết nối và phục vụ cộng đồng.'),
('24.2', '24.2.5', 5, 'Có kế hoạch cải tiến chất lượng phục vụ cộng đồng, đóng góp cho xã hội căn cứ thông tin phản hồi của các bên liên quan.'),

-- Tiêu chí 24.3
('24.3', '24.3.1', 1, 'CSGD có kế hoạch và thực hiện đánh giá tác động của hoạt động kết nối và phục vụ cộng đồng đối với người học và đội ngũ cán bộ, giảng viên, nhân viên.'),
('24.3', '24.3.2', 2, 'Có hệ thống giám sát về tác động xã hội và kết quả của hoạt động kết nối và phục vụ cộng đồng đối với người học và đội ngũ cán bộ, giảng viên, nhân viên.'),
('24.3', '24.3.3', 3, 'Có thực hiện đối sánh về tác động xã hội và kết quả của hoạt động kết nối và phục vụ cộng đồng.'),
('24.3', '24.3.4', 4, 'Có hệ thống thu thập thông tin phản hồi của các bên liên quan về tác động xã hội và kết quả của hoạt động kết nối và phục vụ cộng đồng đối với người học và đội ngũ cán bộ, giảng viên, nhân viên.'),
('24.3', '24.3.5', 5, 'Có kế hoạch cải tiến chất lượng phục vụ cộng đồng đối với người học và đội ngũ cán bộ, giảng viên, nhân viên.'),

-- Tiêu chí 24.4
('24.4', '24.4.1', 1, 'CSGD có kế hoạch và thực hiện khảo sát, đánh giá, giám sát sự hài lòng của các bên liên quan về hoạt động kết nối và phục vụ cộng đồng, đóng góp cho xã hội hằng năm.'),
('24.4', '24.4.2', 2, 'Có hệ thống thu thập thông tin phản hồi của các bên liên quan về tác động của hoạt động kết nối và phục vụ cộng đồng, đóng góp cho xã hội.'),
('24.4', '24.4.3', 3, 'Có hệ thống giám sát sự hài lòng của các bên liên quan về hoạt động kết nối và phục vụ cộng đồng, đóng góp cho xã hội.'),
('24.4', '24.4.4', 4, 'Có thực hiện đối sánh sự hài lòng của các bên liên quan; rà soát, điều chỉnh các hoạt động kết nối và phục vụ cộng đồng hằng năm.'),
('24.4', '24.4.5', 5, 'Có kế hoạch cải tiến chất lượng hoạt động kết nối và phục vụ cộng đồng căn cứ thông tin phản hồi của các bên liên quan.'),

-- Tiêu chí 25.1
('25.1', '25.1.1', 1, 'CSGD có quy định cụ thể về kết quả và các chỉ số tài chính đạt được của hoạt động đào tạo, NCKH và phục vụ cộng đồng.'),
('25.1', '25.1.2', 2, 'Có hệ thống giám sát về kết quả và các chỉ số tài chính của hoạt động đào tạo, NCKH và phục vụ cộng đồng.'),
('25.1', '25.1.3', 3, 'Có thực hiện đối sánh về kết quả và các chỉ số tài chính của hoạt động đào tạo, NCKH và phục vụ cộng đồng; thực hiện rà soát, điều chỉnh hằng năm.'),
('25.1', '25.1.4', 4, 'Có hệ thống thu thập thông tin phản hồi của các bên liên quan về kết quả và các chỉ số tài chính của hoạt động đào tạo, NCKH và phục vụ cộng đồng.'),
('25.1', '25.1.5', 5, 'Có kế hoạch cải tiến chất lượng hoạt động căn cứ thông tin phản hồi của các bên liên quan về kết quả và các chỉ số tài chính.'),
('25.1', '25.1.6', 6, 'Có CSDL đánh giá về kết quả và các chỉ số tài chính của hoạt động đào tạo, NCKH và phục vụ cộng đồng.'),

-- Tiêu chí 25.2
('25.2', '25.2.1', 1, 'CSGD có quy định cụ thể về kết quả và các chỉ số thị trường giáo dục (chỉ số cạnh tranh, thứ hạng, thị phần…) của hoạt động đào tạo, NCKH và phục vụ cộng đồng.'),
('25.2', '25.2.2', 2, 'Có hệ thống giám sát về kết quả và các chỉ số thị trường của hoạt động đào tạo, NCKH và phục vụ cộng đồng.'),
('25.2', '25.2.3', 3, 'Có thực hiện đối sánh về kết quả và các chỉ số thị trường của hoạt động đào tạo, NCKH và phục vụ cộng đồng; thực hiện rà soát, điều chỉnh hằng năm.'),
('25.2', '25.2.4', 4, 'Có hệ thống thu thập thông tin phản hồi của các bên liên quan về kết quả và các chỉ số thị trường của hoạt động đào tạo, NCKH và phục vụ cộng đồng.'),
('25.2', '25.2.5', 5, 'Có kế hoạch cải tiến chất lượng hoạt động căn cứ thông tin phản hồi của các bên liên quan về kết quả và các chỉ số thị trường.'),
('25.2', '25.2.6', 6, 'Có CSDL đánh giá về kết quả và các chỉ số thị trường của hoạt động đào tạo, NCKH và phục vụ cộng đồng.'),